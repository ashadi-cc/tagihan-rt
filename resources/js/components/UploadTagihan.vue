<template>
    <div>
        <form-tagihan :formToken="token" :formFilter="options" :billings="billings" :baseUrl="baseUrl" @changeFilter="changeFilterOption($event)" />
    </div>
</template>

<script>
import FormTagihan from './FormTagihan'

export default {
    props: [
        'token',
        'billings',
        'options',
        'baseUrl',
    ],
    components: {
        FormTagihan
    },
    methods: {
        changeFilterOption(data)
        {
            if (!data.tagihan) {
                return;
            }
            
            console.log(data)
        }
    }
}
</script>