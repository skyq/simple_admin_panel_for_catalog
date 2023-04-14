<template>
    <ul class="list-group list-group-flush ">
        <li class="alert alert-danger" style="list-style-type: none;" v-if="this.alarm">
            <p>Обновите страницу. Ошибка связи с сервером</p>
            {{ this.error }}
        </li>
        <li class="alert alert-dark" style="list-style-type: none;" v-if="!this.orders.length">
            Пока ничего нет
        </li>
        <li :class="[
            this.new_orders.includes(order.id) ? 'list-group-item-success': '',
            'list-group-item d-flex justify-content-between align-items-center']"
            v-on:click="unshift_new_orders(order.id)"
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
            orders: [],
            orders_ids: [],
            new_orders: [],
            alarm: false,
            error: "",
        }
    },
    mounted() {
        this.load_orders()
        setInterval(() => this.update_orders(), 5000)
    },
    updated() {
    },
    methods: {
        unshift_new_orders(id) {
            let index = this.new_orders.indexOf(id)
            if (index >= 0) {
                console.log('delete ', id)
                delete this.new_orders[index]
            }
            console.log(this.new_orders, id)
        },
        async update_orders() {
            // console.log('update_orders')
            let orders = await this.get_tables()
            let add_to_new = this.orders.length > 0
            orders.forEach(el => {
                if (!this.orders_ids.includes(el.id)) {
                    this.orders.unshift(el)
                    this.orders_ids.push(el.id)
                    if (add_to_new)
                        this.new_orders.push(el.id)
                }
            })
        },
        async load_orders() {
            this.orders = await this.get_tables()
            this.orders.forEach(el => this.orders_ids.push(el.id))
            this.new_orders = []
        },
        async get_tables() {
            let orders = []
            await axios.get('https://proxy.profpotok.ru/test/api/table_orders', {timeout: 1000 * 5})
                .then((r) => {
                    // console.log(r)
                    this.alarm = r.status != 200
                    orders = r.data
                }).catch(error => {
                    this.error = error.message
                    // console.log(error)
                    this.alarm = true
                })

            return orders
        },
        dateTime(v) {
            return moment(v).format('HH:mm');
        }
    },
}
</script>
