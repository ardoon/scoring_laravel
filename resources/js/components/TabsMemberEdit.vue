<template>
    <div class="row">
        <div class="col">

            <div class="row">
                <div class="col">
                    <ul class="nav nav-tabs mt-5">
                        <li v-for="tab in tabs" class="nav-item" :key="tab.slug" @click="changeSlug(tab.slug)">
                            <button class="nav-link ml-2 tab-nav-link" :class="{ active : slug === tab.slug}">{{ tab.label }}</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="tab col" :class="{ show : slug === 'update-info'}">
                    <slot name="update-info"></slot>
                </div>

                <div class="tab col" :class="{ show : slug === 'change-password'}">
                    <slot name="change-password"></slot>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "TabContainer",
    props: [
        'oldActiveTab'
    ],
    data () {
        return {
            tabs: [
                {
                    'slug' : 'update-info',
                    'label' : 'ویرایش اطلاعات'
                },
                {
                    'slug' : 'change-password',
                    'label' : 'تنظیمات امنیتی'
                }
            ],
            slug: ''
        }
    },
    methods : {
        changeSlug (slug) {
            this.slug = slug
        }
    },
    mounted() {
        this.slug = this.tabs[0].slug

        if (this.oldActiveTab)
            this.slug = this.oldActiveTab
    }
}
</script>

<style scoped>
    .tab {
        display: none;
    }
    .tab.show {
        display: block;
    }

    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
        background-color: #fdfdfd ;
        border-bottom: 1px solid #fdfdfd ;
    }

</style>
