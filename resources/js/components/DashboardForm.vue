<template>
    <form method="post" :action="formAction">

        <slot></slot>

        <hr>

        <div class="form-row">
            <div class="form-group col-12">
                <button type="submit" class="btn btn-dark px-5 float-left">{{ btnTitle }}</button>
                <slot name="extra-buttons"></slot>
            </div>
        </div>

    </form>
</template>

<script>
export default {
    name: "DashboardPaymentCreateForm",
    props: [
        'formAction',
        'formTitle',
        'btnTitle'
    ],
}
</script>
