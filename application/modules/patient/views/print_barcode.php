<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- invoice start-->
        <section>
            <div class="panel panel-primary">
                <!--<div class="panel-heading navyblue"> INVOICE</div>-->
                <div  class="panel-body col-md-5 panel-moree" id="invoice" style="font-size: 10px;">
                    <div class="row invoice-list">

                        <div class="text-center corporate-id">

                        </div>


                        <div class="col-lg-4 col-sm-4 details">

                        </div>



                        <div class="col-lg-4 col-sm-4 details pull-right">

                        </div>

                        <div class="col-lg-4 col-sm-4 details">

                        </div>
                    </div>


                    <div class="row">
                        <div class="center" style="
                             text-align: center;">
                            <img  class="center" src="<?php echo base_url(); ?>files/barcode/<?php echo $barcode_image; ?>" />
                        </div>
                    </div>





                </div>

                <div class="col-md-5 panel-moree" style="font-size: 10px;">

                    <div class="text-center invoice-btn clearfix">
                        <a class="btn btn-info btn-lg editbutton pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
                    </div>





                </div>



            </div>
        </section>
        <!-- invoice end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->











<style>

    th{
        text-align: center;
    }

    td{
        text-align: center;
    }

    tr.total{
        color: green;
    }



    .control-label{
        width: 100px;
    }



    h1{
        margin-top: 5px;
    }


    .print_width{
        width: 50%;
        float: left;
    } 

    ul.amounts li {
        padding: 0px !important;
    }

    .invoice-list {
        margin-bottom: 10px;
    }




    .panel{
        border: 0px solid #5c5c47;
        background: transparent !important;
        height: 100%;
        margin: 20px 5px 5px 5px;
        border-radius: 0px !important;
        min-height: 700px;

    }



    .table.main{
        margin-top: -50px;
    }



    .control-label{
        margin-bottom: 0px;
    }

    tr.total td{
        color: green !important;
    }

    .theadd th{
        background: #edfafa !important;
        background: #fff!important;
    }

    td{
        font-size: 12px;
        padding: 5px;
        font-weight: bold;
    }

    .details{
        font-weight: bold;
    }

    hr{
        border-bottom: 0px solid #f1f1f1 !important;
    }

    .corporate-id {
        margin-bottom: 5px;
    }

    .adv-table table tr td {
        padding: 5px 10px;
    }



    .btn{
        margin: 10px 10px 10px 0px;
    }

    .invoice_head_left h3{
        color: #2f80bf !important;
    }


    .invoice_head_right{
        margin-top: 10px;
    }

    .invoice_footer{
        margin-bottom: 10px;
    }






    .invoice_head_left h4{
        font-size: 12px !important;
    }



    @media print {

        h1{
            margin-top: 5px;
        }

        #main-content{
            padding-top: 0px;
        }

        .print_width{
            width: 50%;
            float: left;
        } 

        ul.amounts li {
            padding: 0px !important;
        }

        .invoice-list {
            margin-bottom: 0px;
        }

        .invoice-list h4{
            font-size: 12px !important;
        }



        .wrapper{
            margin-top: 0px;
        }

        .wrapper{
            padding: 0px 0px !important;
            background: #fff !important;

        }

        img{
            width: 100px !important;

        }



        .wrapper{
            border: 2px solid #777;
        }

        .panel{
            border: 0px solid #5c5c47;
            background: #fff !important;
            padding: 0px 0px;
            height: 100%;
            margin: 5px 5px 5px 5px;
            border-radius: 0px !important;

        }

        .site-min-height {
            min-height: 950px;
        }



        .table.main{
            margin-top: -50px;
        }



        .control-label{
            margin-bottom: 0px;
            width: auto;
        }

        tr.total td{
            color: green !important;
        }

        .theadd th{
            background: #777 !important;
        }

        td{
            font-size: 10px !important;
            padding: 5px;
            font-weight: bold;
        }

        .details{
            font-weight: bold; 
            font-size: 8px;
            width: 33%;
            float: left;
        }

        hr{
            border-bottom: 0px solid #f1f1f1 !important;
        }

        .corporate-id {
            margin-bottom: 5px;
        }

        .adv-table table tr td {
            padding: 5px 10px;
        }

        .invoice_head{
            width: 100%;
        }

        .invoice_head_left{
            float: left;
            width: 40%;
            color: #2f80bf;
        }

        .invoice_head_right{
            float: right;
            width: 40%;
            margin-top: 10px;
        }

        .hr_border{
            width: 100%;
            margin: -15px;
        }

        .invoice_footer{
            margin-bottom: 10px;
        }


    }
    @media print {

        html, body {
            height:100%; 
            margin: 0 !important; 
            padding: 0 !important;
            overflow: hidden;
        }
        img {
            width : 70px !important;
            height : 12px ;
        }
    }

</style>

















<script src="common/js/codearistos.min.js"></script>
<script>
                            $(document).ready(function () {
                                $(".flashmessage").delay(3000).fadeOut(100);
                            });
</script>
<script type="text/javascript">
    <!--
       window.print();
    //-->
</script>

<style>
    @page {
        size: 2cm 3cm;
        margin:0mm;

    }