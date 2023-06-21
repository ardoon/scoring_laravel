<template>
    <div class="container">

        <div class="row mt-5">
            <span class="page-info"> {{ payments.from }} تا {{ payments.to }} از {{ payments.total }} - صفحه {{ payments.current_page }} از {{ payments.last_page }}</span>
            <div class="col">
                <a :href="createPageUrl" class="btn btn-dark float-left mr-2">افزودن پرداخت جدید</a>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                <table class="table custom-row-color">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">نام پرداخت کننده</th>
                        <th scope="col">شماره رسید پرداخت</th>
                        <th scope="col">تاریخ پرداخت</th>
                        <th scope="col">مبلغ پرداخت</th>
                        <th scope="col" class="icon-column">ویرایش</th>
                    </tr>
                    </thead>
                    <tbody v-if="payments.length !== 0">
                    <tr v-for="(payment, index) in payments.data" :key="payment.id">
                        <th scope="row">{{ payments.from + index }}</th>
                        <td><a :href="'/members/' + payment.payerId">{{ payment.payerFullName }}</a></td>
                        <td>{{ payment.paymentNo }}</td>
                        <td>{{ payment.paymentDate }}</td>
                        <td>{{ formatPrice(payment.paymentAmount) }}</td>
                        <td class="icon-column">
                            <a class="nav-link p-0 m-0" :href="paymentShowUrl + payment.id + '/edit'">
                                <span class="fa fa-edit icon-table"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="6" class="text-center">هیچ رسید پرداختی تا به اکنون ذخیره نشده است</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <table-pagination
            :total="payments.total"
            :per-page="payments.per_page"
            :prev="payments.prev_page_url"
            :next="payments.next_page_url"
            :last-page="payments.last_page"
            :current-page="payments.current_page"
            @navigate="fetchPayments">
        </table-pagination>

    </div>
</template>


<script>
export default {
    props: [
        'createPageUrl'
    ],
    data() {
        return {
            payments: [],
            paymentShowUrl: '/payments/',
            paymentShowUrlPage: '/payments/?page=',
        }
    },
    mounted() {
        axios
            .get(this.paymentShowUrl + 'all')
            .then(response => {
                this.payments = response.data
            })
    },
    methods: {
        fetchPayments(nav) {
            if (this.isNextBlock(nav) || this.isPrevBlock(nav))
                return

            axios
                .get(nav)
                .then(response => {
                    this.payments = response.data
                })
        },
        isNextBlock(nav) {
            return (this.payments.current_page === this.payments.last_page && nav === this.payments.next_page_url)
        },
        isPrevBlock(nav) {
            return (this.payments.current_page === 1 && nav === this.payments.prev_page_url)
        },
        formatPrice(value) {
            return new Intl.NumberFormat().format(value)
        }
    },
}
</script>

<style scoped>
    .page-info {
        padding-top: 10px;
        padding-right: 15px;
    }
</style>

