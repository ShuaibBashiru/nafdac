
<template>
<div :style="opacity">
<GeneralHeader>


<div class="container p-0">
    <div class="row">
        <div class="col-md-12">
            <section v-if="alert!=''">
            <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
            </section>
        </div>
        <div class="col-md-12 mb-2">
           <div class="input-group">
                <input type="text" class="form-control" v-model="product_id" placeholder="Enter product ID">
               <span class="input-group-text" @click="preview">Search</span>

           </div>
        </div>
        <div class="col-md-12">
            <h4>Product Information</h4>
            <section v-if="record==true">
            <div class="table-responsive">
     
                <table class="table table-hover table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">s/n</th>
                            <th scope="col">Product Owner</th>
                            <th scope="col">Product name</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Description</th>
                        </tr>
                      </thead>
                      <tbody>
                    <tr v-for="(d, index) in info" :key="index">
                    <td> {{index + 1}} </td>
                    <td> {{d['company_name']}} </td>
                    <td> {{d['category_name']}} </td>
                    <td> {{d['product_id']}} </td>
                    <td> {{d['descriptions']}} </td>
                       </tr>
                      </tbody>
                </table>
            </div>
</section>
<section v-else>
    <p class="text-danger mt-2">No Information about this product</p>
</section>

        </div>
    </div>
    </div>
</GeneralHeader>

<!-- modal -->
</div>
</template>

<script>
import axios from 'axios'
export default {
    data (){
        return{
        usersession: '',
        serverMessage: 'Please wait...',
        auth_check: false,
        token: '',
        baseData: '',
        baseDataname: '',
        downloadmsg:'',
        isdownload:false,
        alert: null,
        alertmodal: null,
        error: '',
        product_id: '',
        info: [],
        filterlist:'',
        search:'',
        checked: true,
        list_id: [],
        get_list_array: '0',
        listStatus:'',
        displayNumber:10,
        selectToggleValue: '',
        visibility: '',
        selectedlist: null,
        isChecked:false,
        loader: false,
        loadermodal: false,
        selectDefault:"Select",
        classname: '',
        classnamemodal: null,
        submit: 'Submit',
        submittxt:'Submit',
        searchbtn:'Search',
        searchbtntxt:'Search',
        isDisabled: false,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        error_btn: null,
        errormodal: null,
        record:true,
        norecord: '',
        counter:'0'
    }
    },

    created(){
    // this.preview()
    }, 

    methods:{
      checkSession: function(){
        if (this.$session.exists()) {
            this.usersession = this.$session.get('usersession')
            }else{
                return false
                }
        },
   

    preview: function(){
        this.norecord = 'Synchronizing...'
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        axios.get(process.env.VUE_APP_API+'/api/products/list/',{
              params:{
                limitTo: this.displayNumber,
                userid: 0,
                product_id: this.product_id,
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.alert=''
            this.classname=''
            this.info = response.data.result
            this.counter = this.info.length
            this.record = true
            this.$Progress.finish()
            this.opacity = this.opacity_disable
            }else{
            this.record = false
            this.counter = '0'
            this.alert=''
            this.norecord=response.data.msg
            this.classname=''
            this.$Progress.finish()
            this.opacity = this.opacity_disable

            }
        
        }).catch(()=>{
            this.record = false
            this.norecord=''
            this.counter = '0'
            this.classname='alert-danger p-2'
            this.alert=localStorage.getItem('error')
            this.$Progress.fail()
            this.opacity = this.opacity_disable
        })
    },

      


    },


    }
</script>