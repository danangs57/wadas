<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                
                <!-- /.col -->
               
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div v-for="char in chart" :key="char.id" class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{char.name}}</span>
                            <span class="info-box-number">Sold : {{char.transactions_count}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
              
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Latest Orders </h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <br>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                         <Transaction/>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <p class="lead">Companies</p>
                <!-- Info Boxes Style 2 --> 
                <span >

                    <div v-for="(company) in companies" :key="company.id"  class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">{{company.name}}</span>
                    </div>
                <!-- /.info-box-content -->
                </div>
                </span>
                <!-- /.info-box -->
               
                <!-- /.info-box -->
           
                <!-- /.info-box -->
              
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</template>

<script>
import Transaction from './Transaction.vue'
    export default {
        data(){
            return{
                companies:[],
                chart:[],
            }
        },
    mounted() {
        this.getproducts();
        this.getSellingProduct();
        
    },methods:{
        getproducts(){
                           axios.get("api/company").then(({ data }) => (this.companies = data.data.data ));

        },

        getSellingProduct(){
                           axios.get("api/product/selling").then(({ data }) => {this.chart = data.data
                           ,console.log(data.data)
                           });

        },

    },
    components: { Transaction }
}
</script>
