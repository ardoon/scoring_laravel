<template>
    <div class="container-fluid">

        <div class="pop-up" v-if="showModal" @click="showModal = false">
            <div class="pop-up-menu px-3" @click.stop>
                <span class="fa fa-remove pop-up-close" @click="showModal = false"></span>

                <div class="form-group">
                    <label for="changeTableFontSize">سایز فونت جدول</label>
                    <input id="changeTableFontSize" type="number" min="10" max="30" class="form-control" v-model="tableFontSize">
                </div>

                <span class="h6 mt-4 mb-4 d-block">مدیریت ستون ها</span>

                <div class="form-group">
                    <input id="Columns-nationalId" type="checkbox" class="form-check-inline" v-model="Columns.nationalId">
                    <label for="Columns-nationalId">کدملی</label>
                </div>

                <div class="form-group">
                    <input id="Columns-areaMeters" type="checkbox" class="form-check-inline" v-model="Columns.areaMeters">
                    <label for="Columns-areaMeters">متراژ</label>
                </div>

                <div class="form-group">
                    <input id="Columns-mobile" type="checkbox" class="form-check-inline" v-model="Columns.mobile">
                    <label for="Columns-mobile">شماره تماس</label>
                </div>

                <div class="form-group">
                    <input id="Columns-registryDate" type="checkbox" class="form-check-inline" v-model="Columns.registryDate">
                    <label for="Columns-registryDate">تاریخ عضویت</label>
                </div>

                <div class="form-group">
                    <input id="Columns-amount" type="checkbox" class="form-check-inline" v-model="Columns.amount">
                    <label for="Columns-amount">موجودی</label>
                </div>

                <div class="form-group">
                    <input id="Columns-debt" type="checkbox" class="form-check-inline" v-model="Columns.debt">
                    <label for="Columns-debt">بدهی</label>
                </div>

                <div class="form-group">
                    <input id="Columns-proportion" type="checkbox" class="form-check-inline" v-model="Columns.proportion">
                    <label for="Columns-proportion">نسبت موجودی به تکلیف</label>
                </div>

                <div class="form-group">
                    <input id="Columns-penaltiesAmount" type="checkbox" class="form-check-inline" v-model="Columns.penaltiesAmount">
                    <label for="Columns-penaltiesAmount">جریمه دیرکرد</label>
                </div>

                <div class="form-group">
                    <input id="Columns-generalScores" type="checkbox" class="form-check-inline" v-model="Columns.generalScores">
                    <label for="Columns-generalScores">امتیازات عمومی</label>
                </div>

                <div class="form-group">
                    <input id="Columns-paymentsScores" type="checkbox" class="form-check-inline" v-model="Columns.paymentsScores">
                    <label for="Columns-paymentsScores">امتیازات پرداخت</label>
                </div>

                <div class="form-group">
                    <input id="Columns-totalScores" type="checkbox" class="form-check-inline" v-model="Columns.totalScores">
                    <label for="Columns-totalScores">جمع امتیازات</label>
                </div>

            </div>
        </div>

        <div class="pop-up" v-if="showModal1" @click="showModal1 = false">
            <div class="pop-up-menu px-3" @click.stop>
                <span class="fa fa-remove pop-up-close" @click="showModal1 = false"></span>

                <div class="form-group mt-3">
                    <label>افزودن فیلتر</label>
                    <select class="form-control" v-model="filterKey">
                        <option v-for="(filterOption, key) in filterOptions" :value="key">{{ filterOption }}</option>
                    </select>
                    <select class="form-control mt-2" v-model="filterOperator">
                        <option value="=">برابر</option>
                        <option value="<">کوچکتر</option>
                        <option value=">">بزرگتر</option>
                        <option value="<=">کوچکتر مساوری</option>
                        <option value=">=">بزرگتر مساوی</option>
                    </select>
                    <input type="text" class="form-control mt-2" v-model="filterValue" placeholder="مقدار را وارد کنید">
                    <input type="button" class="btn btn-dark w-100 mt-2" value="افزودن" @click="addFilter">
                </div>

                <hr>

                <p class="h6 mb-2">لیست فیلتر ها</p>
                <ul class="list-group pr-0">
                    <li v-for="(filter) in filters" class="list-group-item d-flex justify-content-between align-items-center px-2 py-1">
                        {{ filter.title }} {{ filter.operator }} {{ filter.value }}
                        <span class="fa fa-trash-o delete-filter-item" @click="delFilterItem(filter.id)"></span>
                    </li>
                </ul>

            </div>
        </div>

        <div class="row mt-3 d-print-none">
            <div class="col">
                <form class="form-inline my-2 my-lg-0 float-right">
                    <input
                        class="form-control"
                        type="search"
                        placeholder="جستجو.."
                        aria-label="Search"
                        v-model="search"
                    />
                </form>
                <span class="fa fa-tasks show-settings mr-2" @click="showModal = true"></span>
                <span class="fa fa-filter show-settings" @click="showModal1 = true"></span>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table custom-row-color" :style="{ fontSize: tableFontSize + 'px' }">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" @click="sort('firstName')">نام
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'firstName' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'firstName' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'firstName'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.nationalId">کدملی</th>
                        <th scope="col" v-show="Columns.areaMeters" @click="sort('areaMeters')">متراژ
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'areaMeters' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'areaMeters' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'areaMeters'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.mobile">شماره تماس</th>
                        <th scope="col" v-show="Columns.registryDate">تاریخ عضویت</th>
                        <th scope="col" v-show="Columns.amount" @click="sort('sumPaymentsAmounts')">موجودی <small>(تومان)</small>
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'sumPaymentsAmounts' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'sumPaymentsAmounts' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'sumPaymentsAmounts'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.debt" @click="sort('current_debt')">بدهی
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'current_debt' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'current_debt' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'current_debt'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.proportion" @click="sort('proportion')">نسبت موجودی به تکلیف
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'proportion' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'proportion' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'proportion'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.penaltiesAmount" @click="sort('penalties_sum')">جریمه دیرکرد
                            <small>(تومان)</small>
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'penalties_sum' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'penalties_sum' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'penalties_sum'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.generalScores" @click="sort('general_scores_sum')">امتیازات
                            عمومی
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'general_scores_sum' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'general_scores_sum' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'general_scores_sum'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.paymentsScores" @click="sort('sumPaymentsScores')">امتیازات
                            پرداخت
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'sumPaymentsScores' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'sumPaymentsScores' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'sumPaymentsScores'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" v-show="Columns.totalScores" @click="sort('totalScores')">جمع امتیازات
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'totalScores' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'totalScores' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'totalScores'
                                    }"
                            ></span>
                        </th>
                    </tr>
                    </thead>
                    <tbody v-if="members.length !== 0">
                    <tr v-for="(member, index) in filteredMembers" :key="member.id">
                        <th scope="row">{{ ++index }}</th>
                        <td><a class="show-member-link" :href="memberUrl + member.id">{{ member.firstName }}
                            {{ member.lastName }}</a></td>
                        <td v-show="Columns.nationalId">{{ member.nationalId }}</td>
                        <td v-show="Columns.areaMeters">{{ member.areaMeters }}</td>
                        <td v-show="Columns.mobile">{{ member.mobile }}</td>
                        <td v-show="Columns.registryDate">{{ member.properties.registeryYear }}/{{
                                member.properties.registeryMonth
                            }}/{{ member.properties.registeryDay }}
                        </td>
                        <td v-show="Columns.amount">{{ formatPrice(member.sumPaymentsAmounts) }}</td>
                        <td v-show="Columns.debt">{{ formatPrice(member.current_debt) }}</td>
                        <td v-show="Columns.proportion">{{ member.proportion }}%</td>
                        <td v-show="Columns.penaltiesAmount">{{ formatPrice(member.penalties_sum) }}</td>
                        <td v-show="Columns.generalScores">{{ member.general_scores_sum }}</td>
                        <td v-show="Columns.paymentsScores">{{ member.sumPaymentsScores }}</td>
                        <td v-show="Columns.totalScores">{{ member.totalScores }}</td>
                    </tr>
                    </tbody>

                    <tbody v-else>
                    <tr>
                        <td colspan="7" class="text-center">در حال آماده سازی اطلاعات..</td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            members: [],
            currentSort: 'firstName',
            currentSortDir: 'asc',
            search: '',
            memberShowUrl: '/reports/',
            memberUrl: '/members/',
            tableFontSize: 12,
            showModal: false,
            showModal1: false,
            Columns: {
                nationalId: false,
                areaMeters: true,
                mobile: false,
                registryDate: true,
                amount: true,
                debt: false,
                penaltiesAmount: false,
                generalScores: false,
                paymentsScores: false,
                totalScores: true,
                proportion: true
            },
            filterKey: "areaMeters",
            filterValue: 0,
            filterOperator: '=',
            filterID: 0,
            filterOptions: {
                "areaMeters": 'متراژ',
                "sumPaymentsAmounts": 'موجودی',
                "current_debt": 'بدهی',
                "proportion":'نسب موجودی به تکلیف',
                "penalties_sum": 'جریمه دیرکرد',
                "general_scores_sum": 'امتیازات عمومی',
                "sumPaymentsScores": 'امتیازات پرداخت',
                "totalScores": 'جمع امتیازات'
            },
            filters: [
            ]
        }
    },
    mounted() {
        axios
            .get(this.memberShowUrl + 'all')
            .then(response => (this.members = response.data))
    },
    methods: {
        sort: function (s) {
            //if s == current sort, reverse
            if (s === this.currentSort) {
                this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
            }
            this.currentSort = s;
        },
        formatPrice(value) {
            return new Intl.NumberFormat().format(value)
        },
        delFilterItem(itemID) {
            let i = this.filters.map(item => item.id).indexOf(itemID) // find index of your object
            if(this.filters.splice(i, 1)) {
                this.filteredAdvanced()
            }
        },
        addFilter() {
            let newFilter = {
                id: this.filterID,
                title: this.filterTitle(this.filterKey),
                key: this.filterKey,
                operator: this.filterOperator,
                value: this.filterValue
            }
            this.filters.push(newFilter)
            this.filterKey = "areaMeters"
            this.filterOperator = '='
            this.filterValue = ''
            this.filterID += 1
            this.filteredAdvanced()
        },
        filterTitle(key) {
            return this.filterOptions[key]
        },
        filteredAdvanced() {
            let members = this.members
            let filters = this.filters
            filters.forEach(filter => {
                switch (filter.operator) {
                    case '=':
                        members = members.filter(item => {
                            return item[filter.key] == filter.value
                        })
                        break;
                    case '>':
                        members = members.filter(item => {
                            return item[filter.key] > filter.value
                        })
                        break;
                    case '<':
                        members = members.filter(item => {
                            return item[filter.key] < filter.value
                        })
                        break;
                    case '>=':
                        members = members.filter(item => {
                            return item[filter.key] >= filter.value
                        })
                        break;
                    case '<=':
                        members = members.filter(item => {
                            return item[filter.key] <= filter.value
                        })
                        break;
                }
            })
            return members
        }
    },
    computed: {
        sortedMembers: function () {
            let members = this.filteredAdvanced()
            return members.sort((a, b) => {
                let modifier = 1;
                if (this.currentSortDir === 'desc') modifier = -1;
                if (a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                if (a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                return 0;
            });
        },
        filteredMembers() {
            return this.sortedMembers.filter(item => {
                if (item.firstName.toLowerCase().indexOf(this.search.toLowerCase()) > -1) {
                    return true
                } else if (item.lastName.toLowerCase().indexOf(this.search.toLowerCase()) > -1) {
                    return true
                } else if (item.nationalId.toLowerCase().indexOf(this.search.toLowerCase()) > -1) {
                    return true
                } else {
                    return false
                }
            })
        }
    }

}
</script>

<style scoped>
.show-member-link {
    color: #463940;
}

.show-settings {
    font-weight: 900;
    font-size: 20px;
    cursor: pointer;
    float: left;
    background: #f7f7f7;
    padding: 7px;
    border-radius: 3px;
    border: 1px solid #e8e8e8;
}

.show-settings:hover {
    background: #eee;
}

.pop-up {
    position: fixed;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    left: 0;
    top: 0;
    z-index: 999999999999999999;
}

.pop-up-menu {
    height: 100vh;
    width: 20%;
    background: #ddd;
    position: relative;
    padding-top: 50px;
}

.pop-up-close {
    position: absolute;
    left: 10px;
    top: 10px;
    cursor: pointer;
    font-size: 20px;
}

.delete-filter-item {
    cursor: pointer;
}

</style>
