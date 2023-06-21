<template>
    <div class="row justify-content-center" v-if="total > perPage">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link rounded-left-0 border-left-0 rounded-right"
                           :class="{ 'disabled': !prev }"
                           aria-label="آخر"
                           @click.prevent="paginator(baseLink + 1)">
                            <span aria-hidden="true">اول</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link rounded-0"
                           :class="{ 'disabled': !prev }"
                           aria-label="قبل"
                           @click.prevent="paginator(prev)">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="page in pagesLinks"><a class="page-link" :class="{ 'active-page': page === currentPage }" @click.prevent="paginator(baseLink + page)">{{ page }}</a></li>
                    <li class="page-item">
                        <a class="page-link rounded-0"
                           :class="{ 'disabled': !next }"
                           aria-label="بعد"
                           @click.prevent="paginator(next)">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link rounded-right-0 rounded-left"
                           :class="{ 'disabled': !next }"
                           aria-label="آخر"
                           @click.prevent="paginator(baseLink + lastPage)">
                            <span aria-hidden="true">آخر</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</template>

<script>
export default {
    name: "TablePagination",
    props: [
        'total',
        'perPage',
        'next',
        'prev',
        'lastPage',
        'currentPage'
    ],
    data () {
        return {
            baseLink: '/payments/all?page='
        }
    },
    methods: {
        paginator(val) {
            this.$emit('navigate', val)
        }
    },
    computed : {
        pagesLinks() {
            let pages = []

            if (this.currentPage !== 1 && this.currentPage !== 2)
                pages.push(this.currentPage - 2)
            if (this.currentPage !== 1)
                pages.push(this.currentPage - 1)

            pages.push(this.currentPage)

            if (this.currentPage !== this.lastPage)
                pages.push(this.currentPage + 1)

            if (this.currentPage !== this.lastPage && this.currentPage !== this.lastPage - 1)
                pages.push(this.currentPage + 2)

            return pages
        }
    }
}
</script>

<style scoped>
.rounded-left-0 {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
    font-family: "Nunito", sans-serif;
}

.rounded-right-0 {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    font-family: "Nunito", sans-serif;
}

.pagination a {
    color: #63565d;
    cursor: pointer;
}

a.disabled {
    background: #fafafa;
    cursor: default;
}

.active-page {
    background: #463940;
    color: #fff !important;
}

</style>
