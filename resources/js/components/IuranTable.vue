<template>
    <div class="">
        <div class="row">
            <div class="col-md-4">
                <!-- Search form -->
                <div class="form-inline md-form form-sm">
                    <input class="form-control mr-3 w-75" type="text" :placeholder="searchPlaceholder" v-model="query"
                        aria-label="Search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <a href="#" title="clear filter" @click.prevent="query = ''">
                        <i class="fas fa-window-close trash-margin" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="head-keterangan">
                    Keterangan
                </div>
                <div class="btn btn-danger btn-sm">Belum Lunas</div>
                <div class="btn btn-success btn-sm">Lunas</div>
                <div class="btn btn-warning btn-sm">Tidak Wajib</div>
                <div class="btn btn-secondary btn-sm">Status belum ada</div>
                <div class="btn btn-secondary btn-sm">N/A (Kosong)</div>
            </div>
        </div>
        <div class="text-center empty-data" v-show="emptyData">
            Data Iuran tidak ada
        </div>
        <div class="table-responsive" v-show="emptyData == false">
            <table class="table">
                <thead>
                    <tr>
                        <th class="no-td">No</th>
                        <th v-for="(item,index) in tableColumns" :key="index">
                            {{ item }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-show="loadingRecord">
                        <td :colspan="loadingColSpan" class="text-center">Memuat data...</td>
                    </tr>
                    <tr v-for="(item,index) in records" :key="item.id" v-show="loadingRecord == false">
                        <td>{{ index+1 }}</td>
                        <td>{{ item.blok }}</td>
                        <td v-for="(value, idx) in tableRow(item)" :key="idx">
                            <div v-if="value === false">
                                <div class="btn btn-sm btn-secondary">
                                    N/A
                                </div>
                            </div>
                            <status-amount-row :item="value" :baseUrl="baseUrl" v-else>
                            </status-amount-row>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import Swal from 'sweetalert2'
import _ from 'lodash'
import Toastr from 'toastr'
import StatusAmountRow from './StatusAmountRow'

Toastr.options.positionClass = "toast-bottom-right"
Toastr.options.closeButton = true
Toastr.options.hideDuration = 500
Toastr.options.showDuration = 300 

export default {
    components: {
        StatusAmountRow
    },
    props: {
        searchPlaceholder: {
            type: String, 
            default: 'Cari ...'
        },
        baseUrl: {
            type: String, 
            default: null
        },
        filterOption: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            query: '',
            headerTable: '',
            headerData: '',
            loadingRecord: false,
            records: [],
        };
    },
    computed: {
        tableColumns() {
            return this.headerTable.split(',')
        },
        recordItems() {
            return this.headerData.split(',')
        },
        loadingColSpan() {
            return this.tableColumns.length + 1
        },
        emptyData() {
            return this.records.length ? false: true 
        }
    },
    mounted() {

    },
    created() {
        this.debounceGetData = _.debounce(this.requestData, 500)
    },
    watch: {
        query: function(newQuery, oldQuery) {
            this.debounceGetData()
        },
        filterOption: function(){
            this.requestData()
        }
    },
    methods: {
        tableRow(row) {
            let records  = {}
            this.recordItems.forEach(element => {
                if (element != 'id' && element != 'blok') {
                    records[element] = row[element]
                }
            })

            return records
        },

        errorMessage() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        },
        requestData() {
            let me = this
            let  url = `${this.baseUrl}/get`
            let params = {
                params: {
                    q: this.query, 
                    year: this.filterOption.year,
                    month: this.filterOption.month
                }
            }
            me.loadingRecord = true
            me.records = []
            axios.get(url, params)
                .then( response => {
                    me.loadingRecord = false

                    me.headerTable = response.data.headers 
                    me.headerData = response.data.columns
                    me.records = response.data.data
                })
                .catch(err => {
                    me.loadingRecord = false
                    me.errorMessage()
                })
        }
    }
}
</script>

<style scoped>
 .no-td{
     width: 30px;
 }
 .head-keterangan {
     padding: 10px;
     padding-left: 0px;
     font-weight: bold;
 }
 .trash-margin{margin-left: 5px;}
 .table {margin-top: 30px;}
 .empty-data{
     padding: 30px;
     margin-top: 30px;
     border: 1px solid #ced4da;
     color: #495057;
 }
</style>