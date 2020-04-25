<template>
    <div>
        <h3>Tagihan Per Warga</h3>
        <div class="form-group">
            <label for="">Blok</label>
            <input type="text" class="form-control" :value="this.user.blok" disabled>
        </div>
        <div class="form-group">
            <label for="">Nama</label>
            <input type="text" class="form-control" :value="this.user.name" disabled>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5>Tagihan Bulan Sekarang ({{ this.currentMonth }}) </h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Iuran</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in thisMonth" :key="item.id">
                            <td>{{ item.billing_name }}</td>
                            <td>{{ formatAmount(item.amount) }}</td>
                            <td>
                                <status-row 
                                :idRecord="item.id"
                                :baseUrl="baseUrl"
                                :statusProp="item.status"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Tunggakan tagihan</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Iuran</th>
                            <th>Bulan/Tahun</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in otherMonth" :key="item.id">
                            <td>{{ item.billing_name }}</td>
                            <td>{{ item.month_name }} / {{ item.year }}</td>
                            <td>{{ formatAmount(item.amount) }}</td>
                            <td>
                                <status-row 
                                :idRecord="item.id"
                                :baseUrl="baseUrl"
                                :statusProp="item.status"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
import StatusRow from './StatusRow'


export default {
    components:{
        StatusRow
    },
    props: [
        'baseUrl', 
        'blok',
        'year', 
        'month',
        'shouldChange'
    ],
    data() {
        return {
            user: {
                blok: '',
                name: ''
            },
            otherMonth: [],
            thisMonth: [],
            currentMonth: ''
        }
    },
    watch: {
        shouldChange: function(){
            this.requestData()
        }
    },
    methods: {
        formatAmount(amount){
            return Numeral(amount).format('0,0')
        },
        errorMessage() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        },
        requestData() {
            let params = {
                params: {
                    blok: this.blok
                }
            }
            let me = this
            let url = `${this.baseUrl}/user`
            this.thisMonth = []
            this.otherMonth = []
            axios.get(url, params).then(result => {
                me.user = result.data.user 
                me.thisMonth = result.data.thisMonth
                me.otherMonth = result.data.otherMonth
                me.currentMonth = result.data.currentMonth
            }).catch(e => {
                me.errorMessage()
            })
        }
    }
}
</script>