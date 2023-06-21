<template>
    <label class="switch">
        <input type="checkbox" v-model="checked">
        <span class="slider round" @click="setPenaltiesStrictMode"></span>
    </label>
</template>

<script>
export default {
    name: "ToggleIsPenaltiesStrict",
    data () {
        return {
            checked: null
        }
    },
    mounted() {
        axios
            .get('/option/is-penalties-strict')
            .then(response => {
                this.checked = response.data
            })
    },
    methods : {
        setPenaltiesStrictMode() {
            this.checked = !this.checked
            console.log(this.checked)
            let date = {
                isPenaltiesStrict: this.checked,
            }

            axios
                .post('/option/set-penalties-strict-mode',date)
                .then(response => {
                    axios
                        .get('/option/is-penalties-strict')
                        .then(response => {
                            this.checked = response.data
                        })
                })
        }
    }
}
</script>

<style scoped>
.switch {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 26px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #463940;
}

input:focus + .slider {
    box-shadow: 0 0 1px #463940;
}

input:checked + .slider:before {
    -webkit-transform: translateX(18px);
    -ms-transform: translateX(18px);
    transform: translateX(18px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>
