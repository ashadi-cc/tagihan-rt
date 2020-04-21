<template>
    <div>
        <form-filter :formFilter="options"  @changeFilter="changeFilterOption($event)"/>
        <iuran-table :baseUrl="baseUrl" searchPlaceholder="cari blok..." :filterOption="filterOptions" />
    </div>
</template>
<script>
import FormFilter from './FormFilter'
import IuranTable from './IuranTable'

export default {
    components:{
        FormFilter,
        IuranTable
    },
    props:['baseUrl', 'options'],
    data() {
        return {
            filterOptions: {}
        }
    },
    methods: {
        changeFilterOption(data) {
            this.filterOptions = data
        }
    }
}
</script>