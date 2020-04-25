<template>
    <div>
        <div class="form-group">

        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2'

export default {
    props: [
        'baseUrl', 
        'blok',
        'monthName', 
        'year', 
        'month'
    ],
    methods: {
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
                    bloK: this.blok,
                    year: this.year,
                    month : this.month
                }
            }
            let me = this
            let url = `${this.baseUrl}/user`
            axios.get(url, params).then(result => {

            }).catch(e => {
                me.errorMessage()
            })
        }
    }
}
</script>