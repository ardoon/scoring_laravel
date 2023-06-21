<template>
    <div class="row">
        <div class="col">

            <h2 class="h3" :class="{'float-right': btnBackward, 'float-right': btnPrintPage}">{{ pageTitle }}</h2>

            <slot></slot>

            <a v-if="btnPrintPage" @click="printPage" class="float-left nav-print mr-4">
                <span class="fa fa-print"></span> چاپ
            </a>

            <a v-if="btnBackward" :href="btnBackward" class="float-left nav-backward">
                <span class="fa fa-arrow-right"></span> بازگشت
            </a>

        </div>
    </div>
</template>

<script>
export default {
    props: [
        'pageTitle',
        'btnBackward',
        'btnPrintPage'
    ],
    methods : {
        printPage() {
            window.print()
        }
    }
}
</script>

<style scoped>

.nav-backward {
    color: #63565d;
}

.nav-backward:hover {
    text-decoration: none;
    margin-left: 4px;
}

.nav-print {
    color: #63565d;
    cursor: pointer;
}

.nav-print:hover {
    text-decoration: none;
    text-decoration: underline;
}


</style>
