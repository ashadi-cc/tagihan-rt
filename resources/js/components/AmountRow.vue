<template>
    <div class="text-edit">
        <span v-show="editMode == false">
            <a href="#" class="amount-link" @click.prevent="startEdit()">{{ amountText }}</a>
        </span>
        <div class="input-group" v-show="editMode" >
            <input type="number" class="form-control" v-model="amountValue" @keydown.esc="editMode = false" ref="amount" @keydown.enter="saveEdit()">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" @click="saveEdit()">
                    <i class="fa fa-check"></i>
                </button>
                <button class="btn btn-danger" type="button" @click="editMode = false">
                    <i class="fa fa-window-close"></i>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import Swal from 'sweetalert2'

export default {
    props: {
        baseUrl: {
            type: String,
            default: ''
        },
        amountProp: {
            type: Number,
            default: 0
        },
        idRecord: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            editMode: false,
            amount: 0,
            amountValue: 0,
        }
    },
    mounted() {
        this.amount = this.amountProp
    },
    methods: {
        errorMessage() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        },
        startEdit() {
            this.amountValue = this.amount
            this.editMode = true
            let me = this
            setTimeout(function(){
               me.$refs.amount.focus()
            }, 30)
        },
        saveEdit(){
            let url = `${this.baseUrl}/${this.idRecord}`
            let me = this 
            axios.put(url, {amount: this.amountValue}).then( result => {
                if (result.data.success) {
                    me.amount = me.amountValue
                } else {
                    me.errorMessage()
                }
                me.editMode = false
            }).catch( e => {
                me.editMode = false
                me.errorMessage()
            })
        }
    },
    computed: {
        amountText() {
            return Numeral(this.amount).format('0,0')
        }
    }
}
</script>

<style scoped>
    .amount-link{ text-decoration: underline;}
    .text-edit{width: 200px}
</style>