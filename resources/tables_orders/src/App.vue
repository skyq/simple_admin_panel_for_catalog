<template>
    <ul class="list-group list-group-flush ">
        <li class="alert alert-dark" v-if="!this.orders.length">
            Пока ничего нет
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center"
            v-for="order in orders" :key="order.id">
            <span class="fs-2">{{ dateTime(order.updated_at) }}</span>
            {{ order.name }}
            <span class="badge bg-secondary rounded-pill">{{ order.table }}</span>
        </li>
    </ul>
</template>

<script>

import axios from "axios";
import moment from 'moment';

export default {
    name: 'App',
    components: {},
    data() {
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
        get_tables() {
            axios.get('https://proxy.profpotok.ru/test/api/table_orders')
                .then((r) => {
                    this.orders = r.data
                })
        },
        dateTime(v) {
            return moment(v).format('HH:mm');
        }
    },
}
</script>
