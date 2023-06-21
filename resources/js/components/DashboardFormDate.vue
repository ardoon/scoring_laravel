<template>

    <div class="form-group">

        <label>{{ fieldLabel }}</label>

        <div class="clear"></div>

        <input type="number"
               class="form-control date-day col-4 float-right rounded-0 rounded-right"
               :class="{ 'is-invalid': errorDay }"
               v-model="valueDay" :name="day" max="31" min="1">

        <span v-if="errorDay" class="invalid-feedback" role="alert">
            <strong>{{ errorDay }}</strong>
        </span>

        <select class="form-control col-4 float-right rounded-0 border-right-0 border-left-0"
                :class="{ 'is-invalid': errorMonth }"
                :name="month"
                v-model="valueMonth">
            <option v-for="(month,index) in months" :value="++index">{{ month }}</option>
        </select>

        <span v-if="errorYear" class="invalid-feedback" role="alert">
            <strong>{{ errorYear }}</strong>
        </span>

        <input type="number"
               class="form-control date-year col-4 rounded-0 rounded-left" :class="{ 'is-invalid': errorDay }"
               v-model="valueYear" :name="year" max="1410" min="1390">

        <span v-if="errorYear" class="invalid-feedback" role="alert">
            <strong>{{ errorYear }}</strong>
        </span>

    </div>

</template>

<script>
export default {
    name: "DashboardFormField",
    props: {
        'fieldName': String,
        'fieldLabel': String,
        'valueDay': {
            default: 14
        },
        'valueMonth': {
            default: 1
        },
        'valueYear': {
            default: 1394
        },
        'errorDay': String,
        'errorMonth': String,
        'errorYear': String,
    },
    data() {
        return {
            months: [
                'فروردین',
                'اردیبهشت',
                'خرداد',
                'تیر',
                'مرداد',
                'شهرویور',
                'مهر',
                'آبان',
                'آذر',
                'دی',
                'بهمن',
                'اسفند'
            ]
        }
    },
    computed: {
        day() {
            return this.fieldName + 'Day'
        },
        month() {
            return this.fieldName + 'Month'
        },
        year() {
            return this.fieldName + 'Year'
        }
    }
}
</script>

<style scoped>

.date-day {
    border-top-right-radius: 0.25rem !important;
    border-bottom-right-radius: 0.25rem !important;
}

.date-year {
    border-top-left-radius: 0.25rem !important;
    border-bottom-left-radius: 0.25rem !important;
}

</style>
