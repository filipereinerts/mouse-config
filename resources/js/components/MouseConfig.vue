<template>

    <div class="p-2">

        <div class="box pt-5">
            <span class="d-none d-md-block d-lg-block d-xl-block">
                Mouse configuration
            </span>
            <span class="d-md-none d-lg-none d-xl-none" style="font-size: 30px">
                Mouse configuration
            </span>
        </div>

        <br>
        <br>

        <div v-if="mouses.length > 0">

            <div class="box">
                <h4>Select mouse</h4>
            </div>
            <div class="box">
            <span class="badge badge-pill badge-primary p-1 pr-2 pl-2" v-for="mouse in mouses" style="cursor: pointer" @click="setMouse(mouse.id)">
                <i class="fa fa-circle" style="color: green" v-if="mouse.selected"></i>
                {{mouse.name}}
            </span>
            </div>

            <br>
            <br>

            <div class="box">
                <h4>Select color</h4>
            </div>
            <div class="box">
                <div class="div-box"
                     v-for="color in colors"
                     :style="colorClass(color)"
                     @click="setColor(color)"
                     @contextmenu.prevent.stop="removeColor(color)"
                >
                    <i class="fa fa-check fa-2x" v-if="color.selected"></i>
                </div>
                <div class="div-box" style="background-color: black; opacity: 0.2">
                    <input type="color" style="width: 0; height: 0;opacity: 0; position: fixed; cursor: pointer" id="teste" v-model="newColor" @change="addColor">
                    <i class="fa fa-plus fa-2x" onclick="$('#teste').click()"></i>
                </div>
            </div>

            <br>
            <br>

            <div class="box">
                <h4>Select mode</h4>
            </div>
            <div class="box">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="mode-on" v-model="mode" value="on" @change="update">
                    <label class="form-check-label" for="mode-on">
                        On
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="mode-off" v-model="mode" value="off" @change="update">
                    <label class="form-check-label" for="mode-off">
                        Off
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="mode-cycle" v-model="mode" value="cycle" @change="update">
                    <label class="form-check-label" for="mode-cycle">
                        Cycle
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="mode-breathing" v-model="mode" value="breathing" @change="update">
                    <label class="form-check-label" for="mode-breathing">
                        Breathing
                    </label>
                </div>
            </div>

            <br>
            <br>

            <div class="box">
                <h4>Select duration ({{duration}})</h4>
            </div>
            <div class="box">
                <div class="col-lg-4 col-md-4">
                    <input type="range" class="custom-range" min="20" max="10000" v-model="duration" @change="update">
                </div>
            </div>

            <br>
            <br>

            <div class="box">
                <h4>Select brightness ({{brightness}})</h4>
            </div>
            <div class="box">
                <div class="col-lg-4 col-md-4">
                    <input type="range" class="custom-range" min="0" max="255" v-model="brightness" @change="update">
                </div>
            </div>

            <br>
            <br>

            <div class="box">
                <h4>Select dpi</h4>
            </div>
            <div class="box">
                <span v-bind:class="dpi === 200 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 200;update()" style="font-size: 15px">200</span>
                <span v-bind:class="dpi === 600 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 600;update()" style="font-size: 15px">600</span>
                <span v-bind:class="dpi === 1000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 1000;update()" style="font-size: 15px">1000</span>
                <span v-bind:class="dpi === 1400 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 1400;update()" style="font-size: 15px">1400</span>
                <span v-bind:class="dpi === 2000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 2000;update()" style="font-size: 15px">2000</span>
                <span v-bind:class="dpi === 3000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 3000;update()" style="font-size: 15px">3000</span>
                <span v-bind:class="dpi === 4000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 4000;update()" style="font-size: 15px">4000</span>
                <span v-bind:class="dpi === 5000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 5000;update()" style="font-size: 15px">5000</span>
                <span v-bind:class="dpi === 8000 ? 'badge-primary' : 'badge-secondary'" class="badge m-1" @click="dpi = 8000;update()" style="font-size: 15px">8000</span>
            </div>

        </div>
        <div v-else>
            <div class="box">
                <h4>
                    <i class="fa fa-usb"></i>
                    Connect your mouse first
                </h4>
            </div>
        </div>

    </div>

</template>

<script>

    export default {

        name: "MouseConfig",

        data(){

            return {
                colors: [],
                mouses: [],
                newColor: null,
                mode: 'on',
                duration: 2000,
                brightness: 255,
                dpi: 1400
            }

        },

        mounted() {

            $.get('/mouses', function(data){

                this.mouses = data;
                this.update();
                this.getColors();

            }.bind(this));

        },

        methods: {

            update(){

                $.post('/update', {
                    color: this.selectedColor,
                    mouse: this.selectedMouse,
                    mode: this.mode,
                    duration: this.duration,
                    brightness: this.brightness,
                    dpi: this.dpi
                });

            },

            getColors(){

                if(this.selectedMouse){
                    $.get(`/colors/${this.selectedMouse.id}`, function(data){
                        this.colors = data;
                    }.bind(this));
                }

            },

            setColor(color){

                let mouse = this.selectedMouse;

                if(!mouse){

                    alert("Set mouse first");
                    return;

                }

                _.mapValues(this.colors, (color) => color.selected = false);
                color.selected = true;

                this.update();

            },

            setMouse(mouseId){

                _.mapValues(this.mouses, (mouse) => mouse.selected = false);
                let mouse = _.first(this.mouses, {id: mouseId});
                mouse.selected = true;
                this.getColors();

            },

            addColor(){

                let color = _.find(this.colors, {hex: this.newColor});


                if(!color){

                    this.colors.push({
                        hex: this.newColor,
                        selected: false
                    });

                    $.post('/set-colors', {colors: this.colors});

                }

            },

            removeColor(color){

                if(color.selected) return true;

                this.colors = _.reject(this.colors, color);

                $.post('/set-colors', {colors: this.colors});

                return false;

            },

            colorClass(color){

                if(color.selected){

                    return {
                        'background-color' : color.hex,
                    }

                }

                return {
                    'background-color' : color.hex,
                    'border': '6px solid white'
                }

            }

        },

        computed: {

            selectedMouse(){

                return _.first(_.filter(this.mouses, {selected: true}));

            },

            selectedColor(){

                return _.first(_.filter(this.colors, {selected: true}));

            }

        }

    }

</script>

<style scoped>

    .box {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .box .div-box {
        width: 50px;
        height: 50px;
        border-radius: 100%;
        cursor: pointer;
        margin: 4px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .box .div-box i {
        color: white;
    }

</style>
