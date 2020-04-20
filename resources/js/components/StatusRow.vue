<template>
    <div class="btn-group btn-status">
    <button type="button" class="btn" :class="statusClass">{{ statusText }}</button>
    <button type="button" :class="statusClass" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#" @click.prevent="saveStatus('T')">Tidak Wajib</a>
        <a class="dropdown-item" href="#" @click.prevent="saveStatus('B')">Belum Lunas</a>
        <a class="dropdown-item" href="#" @click.prevent="saveStatus('L')">Lunas</a>
    </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
    props:['idRecord', 'statusProp', 'baseUrl'],
    data() {
        return {
            status: ''
        }
    },
    mounted() {
        this.status = this.statusProp
    },
    computed: {
        statusText() {
            if (this.status == 'B') return 'Belum Lunas'
            if (this.status == 'L') return 'Lunas'
            if (this.status == 'T') return 'Tidak Wajib'

            return 'Tidak ada'
        },
        statusClass() {
            if (this.status == 'B') {
                return {
                    'btn-danger': true
                }
            }
            if (this.status == 'L') {
                return {
                    'btn-success': true
                }
            }
            if (this.status == 'T') {
                return {
                    'btn-info': true
                }
            }

            return {
                'btn-default': true
            }
        }
    },
    methods: {
        errorMessage() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        },
        saveStatus(status) {
            let url = `${this.baseUrl}/${this.idRecord}`
            let me = this 
            axios.put(url, {status: status}).then( result => {
                if (result.data.success) {
                    me.status = status
                } else {
                    me.errorMessage()
                }
            }).catch( e => {
                me.errorMessage()
            })
        }
    }
}
</script>

<style scoped>
    .btn-status {width: 150px;}
</style>