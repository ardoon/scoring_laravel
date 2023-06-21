<template>

    <div class="form-group">

        <label :for="fieldName">{{ fieldLabel }}</label>

        <small class="form-input-hint">{{ hint }}</small>

        <input :type="fieldType" class="form-control" :class="{ 'is-invalid': error }" :value="fieldValue" :id="fieldName" :name="fieldName" >

        <span v-if="error" class="invalid-feedback" role="alert">
            <strong>{{ error }}</strong>
        </span>

    </div>

</template>

<script>
export default {
    name: "DashboardFormField",
    props: [
        'fieldName',
        'fieldLabel',
        'fieldType',
        'fieldValue',
        'hint',
        'error',
    ],
    data () {
        return {
            //
        }
    }
}
</script>
