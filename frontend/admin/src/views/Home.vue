<template>
<div :style="opacity">
    <GeneralHeader>
<div class="container-fluid mt-1 p-0">
    <br/>
    <br/>
<div class="row p-0">
    <div class="col-md-2 text-center pt-md-3"> 
    </div>
    <div class="col-md-8 text-center">
        <img src="@/assets/images/logo.png" class="img-fluid" width="200" alt="">
        <h1 class="display-2 mt-2 pt-0 fw-bolder text-center">
           <strong>
             Admin Portal!
           </strong>
        </h1>
 
    </div>
  
        <div class="col-md-2 mt-2 pt-md-5 text-center"> 
        <img src="" class="img-fluid mt-md-5" alt="" width="200">
        </div>
          <div class="col-md-12">
       <div class="col-md-4 m-auto">
       </div>
    </div>
        <div class="col-md-12 mt-4 text-center"> 
            <a href="/app/site/signin"><button class="btn btn-outline-primary m-2 p-2"> <i class="bi-lock"></i> Admin login </button> </a>
            </div>

</div>
</div>
  </GeneralHeader>
</div>
</template>
<style>

</style>
<script>

// import axios from 'axios'
export default {
    data (){
        return{
        alert: '',
        classname: '',
        record:false,
        norecord: '',
        toggle:null,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>