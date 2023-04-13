<template>
    <ul>
        <li v-for="order in orders" :key="order.id">{{dateTime(order.updated_at)}} Стол {{order.table}} хотят {{order.name}}</li>
    </ul>
</template>

<script>

import axios from "axios";
import moment from 'moment';

export default {
    name: 'App',
    components: {},
    data(){
        return {
            orders: []
        }
    },
    mounted() {
        this.get_tables()
    },
    updated() {
        setTimeout(() => this.get_tables(), 10000);
    },
    methods: {
        get_tables(){
            axios.get('https://proxy.profpotok.ru/test/api/table_orders')
                .then((r) => {
                    this.orders = r.data
                })
        },
        dateTime(v){
            return moment(v).format('HH:mm');
        }
    },
}
</script>
