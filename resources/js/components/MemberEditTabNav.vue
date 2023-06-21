<template>
    <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link ml-2 tab-nav-link"
                :class="{ active: activeemt == 'info' }"
                @click="updateActiveTab('info')"
            >ویرایش اطاعات</button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link ml-2 tab-nav-link"
                :class="{ active: activeemt == 'security' }"
                @click="updateActiveTab('security')"
            >تغییر گذرواژه</button>
        </li>
    </ul>
</template>

<script>
export default {
    props: [
        'activeemt'
    ],
    methods: {
        updateActiveTab(value) {
            this.$emit("update-active-tab", value)
        }
    },
    created() {
        this.$emit("update-active-tab", this.activeemt)
    }
}
</script>