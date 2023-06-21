<template>

    <div class="form-group">

        <label :for="fieldName">{{ fieldLabel }}</label>

        <small class="form-input-hint">{{ hint }}</small>

        <select v-model="fieldValue"
                :id="fieldName"
                :name="fieldName"
                class="form-control"
                :class="{ 'is-invalid': error }">

            <option value="none" disabled selected>انتخاب کنید</option>

            <option v-for="(label, value, index) in options" :value="value">{{ label }}</option>

        </select>

        <span v-if="error" class="invalid-feedback" role="alert">
            <strong>{{ error }}</strong>
        </span>

    </div>

</template>

<script>
export default {
    name: "DashboardFormSelect",
    props: {
        'fieldName': String,
        'fieldLabel': String,
        'fieldValue': {
            default: 'none'
        },
        'fieldItems': JSON,
        'hint': String,
        'error': String,
        'api': String
    },
    data () {
        return {
            options: []
        }
    },
    mounted() {

        if(this.fieldItems) {
            this.options = this.fieldItems
        } else {
            axios
                .get(this.api)
                .then(response => (this.options = response.data))
        }

    },
}
</script>
