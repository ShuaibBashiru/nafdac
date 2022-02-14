<template>
<div :style="opacity">
<AdminHeader>
  <section v-if="alert!=''">
      <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
  </section>

<div class="container p-0">
<div class="row">
<div class="col-md-4">
<div class="p-1 pb-0 ml-0 pl-0">
    <h5 class="mt-2 text-primary"> Products (Upload Batch) </h5>
</div>
</div>
<div class="col-md-8 p-0 d-flex justify-content-end">
<div class="btn-toolbar m-1" role="toolbar" aria-label="Toolbar with button groups">
<section v-if="showSaveBtn==true">
<div class="btn-group m-2" title="Save" role="group" aria-label="Second group">
<button type="button" class="btn btn-primary" @click="uploadfile"><i class="bi-save" style="font-size:;"></i> {{saveBtn}} </button>
</div>
</section>
<div class="btn-group m-2" title="Refresh" role="group" aria-label="First group">
<button class="btn btn-outline-primary" @click="$router.go(0)"><i class="bi-arrow-clockwise" style="font-size: 1rem;"></i></button>
</div>

</div>

</div>
<div class="col-md-12">
    <div class="row">
        <div class="col">
            <ul class="nav navbar">
                <li class="text-primary">Total: {{total}}</li>
                <li class="text-success">Uploaded: {{success}}</li>
                <li class="text-warning">Exist: {{exist}}</li>
                <li class="text-danger">Failed: {{failed}}</li>
                <li class="text-primary">Progress: {{progress}}</li>

            </ul>
        </div>
    </div>
</div>
</div>
</div>

<div class="container p-0">
<div class="border">
<div class="row">
    
<div class="col-md-12">
    <div class="p-2">
                <form @submit.prevent="onUpload">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"></legend>
            <div class="row">
        <div class="col-md-4">
                <div class="m-1">
                <div class="input-group">
                   <span class="input-group-text">Company</span>
                    <select v-model="company_id" class="form-control" id="category" required>
                        <option disabled value="" selected>Select</option>
                        <option v-for="(d, index) in category_list" :key="index" :value="d['id']">{{d['company_name']}}</option>
                   </select>
                </div>
                </div>
            </div>
         <div class="col-md-6">
                <div class="m-1">
                <div class="input-group">
                    <span class="input-group-text">File</span>
                    <input type="file" @change="onFileSelected" class="form-control" accept=".xlsx" required>
                </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="m-1">
                <div class="btn-toolbar float-end" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group me-2" title="Preview" role="group" aria-label="First group">
                <button type="submit" class="btn btn-outline-primary" :disabled="isDisabled">{{submit}}</button>
                </div>
                </div>
                </div>
            </div>
                </div>
                </fieldset>
            </form>
        
    </div>
</div>

</div>
</div>
</div>

<div class="container p-0">
    <div class="row">
        <div class="col-md-12">
            <section v-if="record==true">
            <div class="table-responsive">
     
                <table class="table table-hover table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Company</th>
                            <th scope="col">Category</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                        </tr>

                    </thead>
                    <tbody>
                    <tr v-for="(d, index) in info" :key="index">
                    <td>{{index + 1}}</td>
                    <td>{{d['company']}} </td>
                    <td>{{d['category']}}</td>
                    <td>{{d['productname']}}</td>
                    <td>{{d['description']}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
</section>
<section v-else>
    <p class="text-danger mt-2">{{norecord}}</p>
</section>

        </div>
    </div>
    </div>

</AdminHeader>


</div>
</template>

<script>
import axios from 'axios'
import $ from "jquery";
export default {
    data (){
        return{
        serverMessage: 'Please wait...',
        usersession: '',      
        auth_check: false,
        token: '',
        selectedFile: null,
        fileurl:null,
        baseData: '',
        baseDataname: '',
        downloadmsg:'',
        isdownload:false,
        alert: null,
        alertmodal: null,
        error: '',
        info: '',
        category_list: [],
        filename: '',
        showSaveBtn:false,
        filterlist:'',
        search:'',
        checked: true,
        list_id: [],
        get_list_array: '0',
        listStatus:'',
        displayNumber:10,
        selectToggleValue: '',
        company_id: '',
        selectedlist: null,
        isChecked:false,
        loader: false,
        loadermodal: false,
        selectDefault:"Select",
        classname: '',
        classnamemodal: null,
        submit: 'Preview',
        submittxt:'Preview',
        saveBtn:'Upload',
        saveBtntxt:'Upload',
        isDisabled: false,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        error_btn: null,
        errormodal: null,
        record:false,
        norecord: '',
        counter:'0',
        progress:'0%',
        total: 0,
        success: 0,
        failed: 0,
        exist: 0,
    }
    },

    created(){
    this.tokenize()
    this.usersession = this.$session.get('usersession')
    this.Category()
    }, 

    methods:{
    formCheckStatus: function(e){
        if (this.token.length < 1) {
        this.errormodal="Check network connection or reload this page";
        }else if(this.list_id.length < 1 || this.get_list_array.length < 1){
        this.errormodal="Please select the record(s) you wanted to update.";
        }else{
        this.updateStatus()
        }
    e.preventDefault();
    },
     onFileSelected(event){
            this.selectedFile = event.target.files[0]
        },
    onUpload: function(){
        this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        this.submit='Please wait..'
        const form = new FormData();
        form.append('fileupload', this.selectedFile, this.selectedFile.name)
        form.append('userid', this.usersession['id'])
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/upload/products/preview', form, {
        onUploadProgress: uploadEvent => {
        this.progress = Math.round(uploadEvent.loaded / uploadEvent.total * 100) + "%"
        }
        })
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.record =  true
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.info = response.data.result
        this.filename = response.data.filename
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        this.showSaveBtn = true
        }else{
        this.record =  false
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.total = response.data.total
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        this.showSaveBtn = false

        }
    }).catch(()=>{
        this.record =  false
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.submit=this.submittxt
        this.$Progress.fail()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        this.showSaveBtn = false

    })  
    },
    checkifuploaded: function(){
    if (this.file == '') {
        this.showSaveBtn = false
            this.alert = 'Please select a file and preview'
        }else{
            this.showSaveBtn = true
        }
    },
    uploadfile: function(){
        if (this.file == '') {
            this.showSaveBtn = false
            this.alert = 'Please select a file and preview'
        }else{
            this.upload()
        }
    },

    upload: function(){
       this.$Progress.start()
        this.isDisabled = true
        this.opacity = this.opacity_enable
        this.saveBtn='Uploading...'
        const form = new FormData();
        form.append('filename', this.filename)
        form.append('company_id', this.company_id)
        form.append('userid', this.usersession['id'])
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/upload/products/upload', form, {
        })
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.info = response.data.result
        this.total = response.data.total
        this.success = response.data.success
        this.failed = response.data.failed
        this.exist = response.data.exist
        this.saveBtn=this.saveBtntxt
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable
        }else{
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.info = response.data.result
        this.saveBtn=this.saveBtntxt
        this.total = response.data.total
        this.success = response.data.success
        this.failed = response.data.failed
        this.exist = response.data.exist
        this.$Progress.finish()
        this.isDisabled = false
        this.opacity = this.opacity_disable

        }
    }).catch(()=>{
        this.record =  false
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.saveBtn=this.saveBtntxt
        this.$Progress.fail()
        this.isDisabled = false
        this.opacity = this.opacity_disable

    })  
    },

       tokenize: function(){
        this.$Progress.start()
    axios.get(process.env.VUE_APP_API+'/auth/token/tokenize/',{
    params:{
      'token': Math.random(9, 9999)
    }
  }).then(response => {
      if(response.data.status==response.data.statusmsg){
      this.token=response.data.key
      this.isToken=true
      this.tryAgain='d-none'
      axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.key;
      this.$Progress.finish()
      }else{
      this.$Progress.finish()
      this.isToken=false
      this.tryAgain=''
      this.validationClass = response.data.classname
      this.validationMsg=localStorage.getItem('error')
      } 
    
  }).catch(()=>{
      this.$Progress.fail()
      this.validationClass='text-danger p-2'
      this.validationMsg='Network error! refresh and try again or report this error on our contact page.'
      this.isToken=false
      this.tryAgain=''
  })
  },


     Category: function(){
        this.$Progress.start()
        this.opacity = this.opacity_enable
           axios.get(process.env.VUE_APP_API+'/api/company/lists/',{
              params:{
                limitTo: this.displayNumber,
                userid: this.usersession['email_one'],
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.category_list = response.data.result
            this.record = true
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }else{
            this.record = false
            this.counter = '0'
            this.alert=response.data.msg
            this.classname=response.data.classname
            this.$Progress.finish()
            this.isDisabled = false
            this.opacity = this.opacity_disable
            }
        
        }).catch(()=>{
            this.record = false
            this.norecord=''
            this.counter = '0'
            this.classname='alert-danger p-2'
            this.alert=localStorage.getItem('error')
            this.$Progress.fail()
            this.isDisabled = true
            this.opacity = this.opacity_disable
        })
    },

    selectToggle: function(){
    var checkboxes = document.getElementsByName('checkbox');
    if(this.selectToggleValue == false){
        var newlist=[]
        $(checkboxes).each(function() {
            this.checked = true;
            newlist.push(this.value)                        
        });
        this.list_id = newlist
    }else{
        $(checkboxes).each(function() {
            this.checked = false;
        });
        this.list_id = []

      }
        
          },
        unselectAll: function(){
        var checkboxes = document.getElementsByName('checkbox');
             $(checkboxes).each(function() {
            this.checked = false;
        });
        this.list_id = []
        },


    },


    }
</script>