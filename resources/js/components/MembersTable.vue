<template>
    <div class="container" @keydown.ctrl.alt="console.log('hello')">
        <div class="row mt-5">
            <div class="col">
                <a :href="memberCreateUrl" class="btn btn-dark float-left mr-2">افزودن عضو جدید</a>
                <div class="d-inline-block mr-3"><span class="is-penalties-strict-label">جریمه سخت اعضای جدید</span><toggle-is-penalties-strict></toggle-is-penalties-strict></div>
                <form class="form-inline my-2 my-lg-0 float-right">
                    <input
                        class="form-control"
                        type="search"
                        placeholder="جستجو براساس نام کامل"
                        aria-label="Search"
                        v-model="search"
                    />
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table custom-row-color">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" @click="sort('firstName')">
                            نام
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'name' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'name' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'name'
                                    }"
                            ></span>
                        </th>
                        <th scope="col" @click="sort('lastName')">
                            نام خانوادگی
                            <span
                                class="fa"
                                :class="{
                                        'fa-caret-up': currentSort == 'fname' && currentSortDir == 'asc',
                                        'fa-caret-down': currentSort == 'fname' && currentSortDir == 'desc',
                                        'fa-sort': currentSort != 'fname'
                                    }"
                            ></span>
                        </th>
                        <th scope="col">کد ملی</th>
                        <th scope="col" class="edit-column text-center">مشاهده</th>
                        <th scope="col" class="edit-column text-center">پرداخت ها</th>
                        <th scope="col" class="edit-column text-center">جریمه ها</th>
                        <th scope="col" class="edit-column text-center">ویرایش</th>
                    </tr>
                    </thead>
                    <tbody v-if="members.length !== 0">
                    <tr v-for="(member, index) in filteredMembers" :key="member.id">
                        <th scope="row">{{ ++index }}</th>
                        <td>{{ member.firstName }}</td>
                        <td>{{ member.lastName }}</td>
                        <td>{{ member.nationalId }}</td>
                        <td class="icon-column">
                            <a :href="memberShowUrl + member.id">
                                <span class="fa fa-eye icon-table"></span>
                            </a>
                        </td>
                        <td class="icon-column">
                            <a :href="'payments/' + member.id">
                                <span class="fa fa-money icon-table"></span>
                            </a>
                        </td>
                        <td class="icon-column">
                            <a :href="'penalties/' + member.id">
                                <span class="fa fa-balance-scale icon-table"></span>
                            </a>
                        </td>
                        <td class="icon-column">
                            <a class="nav-link p-0 m-0" :href="memberShowUrl + member.id + '/edit'">
                                <span class="fa fa-edit icon-table"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="5" class="text-center">هیچ عضوی تا به اکنون ذخیره نشده است</td>
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
            currentSort: 'name',
            currentSortDir: 'asc',
            search: '',
            memberShowUrl: '/members/',
            memberCreateUrl: '/members/create',
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
        }
    },
    computed: {
        sortedMembers: function () {
            return this.members.sort((a, b) => {
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
    .is-penalties-strict-label {
        vertical-align: -2px;
        margin-left: 5px;
    }
</style>
