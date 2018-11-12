<template>
    <div class="row">
        <div class="col-lg-12">
            <form id="search">
                Search <input name="query" v-model="query" @keyup="search(query)">
            </form>
            <!-- <div class="pull-right">
                {{ total }} Total Results
            </div> -->
            <section class="panel">
                <div class="panel-body">

                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <th>DM PDF</th>
                            <th v-for="key in gridColumns"
                                @click="sortBy(key)"
                                v-bind:class="{active: sortKey == key}">
                                {{ key }}
                                <span class="arrow-small"
                                      v-bind:class="sortOrder > 0 ? 'asc' : 'dsc'">
                                </span>
                            </th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="row in gridData">
                            <td style="width: 16%; height: 200px;">
                                <div  v-bind:title="'/' + row.FileURL" class="img-box dm-box" style="height: 150px;">
                                </div>
                            </td>
                            <td>
                                {{ row.Title }}
                            </td>
                            <td>
                                {{ row.OpenDate }}
                            </td>
                            <td>
                                {{ row.CloseDate }}
                            </td>
                            <td>
                                {{ row.Order }}
                            </td>
                            <td>
                                {{ row.Status }}
                            </td>
                            <td>
                                {{ row.上次編輯者 }}
                            </td>
                            <td>
                                {{ row.上次編輯時間 }}
                            </td>
                            <td >
                                <a v-bind:href="'/backend/dms/' + row.Id + '/edit'">
                                    <button type="button" class="btn btn-default">
                                    編輯
                                    </button>
                                </a>
                                <!-- <div class="form-group">
                                    <form class="form" role="form" method="POST" v-bind:action="'/backend/visual/where-location' + row.Id">
                                        <input type="hidden" name="_method" value="delete">
                                        {{ csrf_field() }}
                                        <input class="btn btn-danger" Onclick="return ConfirmDelete();" type="submit" value="Delete">
                                    </form>
                                </div> -->
                                <button class="btn btn-danger" @click.prevent="confirmDelete(row)">刪除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="pull-right">

                    page {{ current_page }} of   {{ last_page }} pages
                </div> -->

            </section>
            <!-- <div class="row">
                <div class="pull-right for-page-button">

                    <button @click="getData(go_to_page)"class="btn btn-default">
                        Go To Page:</button>
                    <input v-model="go_to_page" class="number-input"></input>

                </div>


                <ul class="pagination pull-right">
                    <li><a @click.prevent="getData(first_page_url)"> first </a></li>
                    <li v-if="checkUrlNotNull(prev_page_url)">
                        <a @click.prevent="getData(prev_page_url)" >prev</a>
                    </li>
                    <li v-for="page in pages"
                        v-if="page > current_page - 2 && page < current_page + 2"
                        v-bind:class="{'active': checkPage(page)}">
                        <a @click.prevent="getData(page)">{{ page }}</a>
                    </li>
                    <li v-if="checkUrlNotNull(next_page_url)">
                        <a @click.prevent="getData(next_page_url)">next</a>
                    </li>
                    <li><a @click.prevent="getData(last_page_url)"> last </a></li>
                </ul>
            </div> -->
        </div>
    </div>

</template>

<script>
    export default {
        mounted: function () {
            this.loadData();
        },
        updated: function() {
            this.renderPDF();
        },
        data: function () {
            return {
                query: '',
                gridColumns: ['Title', 'OpenDate', 'CloseDate', 'Order', 'Status', '上次編輯者', '上次編輯日期'],
                gridData: [],
                // total: null,
                // next_page_url: null,
                // prev_page_url: null,
                // last_page: null,
                // current_page: null,
                // pages: [],
                // first_page_url: null,
                // last_page_url: null,
                // go_to_page: null,
                sortOrder: 1,
                sortKey: ''
            }
        },
        filters: {
            nl2br: function(value) {
                return (value + '')
                    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
            }
        },
        methods: {
            sortBy: function (key){
                this.sortKey = key;
                this.sortOrder = (this.sortOrder == 1) ? -1 : 1;
                this.getData(1);
            },
            search: function(query){
                this.getData(query);
            },
            loadData: function (){
                $.getJSON('/api/dms-data', function (data) {
                    this.gridData = data;
                    // this.total = data.total;
                    // this.last_page =  data.last_page;
                    // this.next_page_url = data.next_page_url;
                    // this.prev_page_url = data.prev_page_url;
                    // this.current_page = data.current_page;
                    // this.first_page_url = 'api/widget-data?page=1';
                    // this.last_page_url = 'api/widget-data?page=' + this.last_page;
                    // this.setPageNumbers();
                    // this.renderPDF();
                }.bind(this));
            },
            // setPageNumbers: function(){
            //     for (var i = 1; i <= this.last_page; i++) {
            //         this.pages.push(i);
            //     }
            // },
            getData: function (request){
                let getPage;
                switch (request){
                    // case this.prev_page_url :
                    //     getPage = this.prev_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.next_page_url :
                    //     getPage = this.next_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.first_page_url :
                    //     getPage = this.first_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    // case this.last_page_url :
                    //     getPage = this.last_page_url +
                    //               '&column=' + this.sortKey +
                    //               '&direction=' + this.sortOrder;
                    //     break;
                    case this.query :
                        getPage = '/api/dms-data?' +
                                  'keyword=' + this.query +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder;
                        break;
                    // case this.go_to_page :
                    //     if( this.go_to_page != '' && this.pageInRange()){
                    //         getPage = 'api/widget-data?' +
                    //                   'page=' + this.go_to_page +
                    //                   '&column=' + this.sortKey +
                    //                   '&direction=' + this.sortOrder +
                    //                   '&keyword=' + this.query;
                    //         this.clearPageNumberInputBox();
                    //     } else {
                    //         alert('Please enter a valid page number');
                    //     }
                    //     break;
                    default :
                        getPage = '/api/dms-data?' +
                                  // 'page=' + request +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder +
                                  '&keyword=' + this.query;
                        break;
                }
                if (this.query == '' && getPage != null){
                    $.getJSON(getPage, function (data) {
                        this.gridData = data;
                        // this.total = data.total;
                        // this.last_page =  data.last_page;
                        // this.next_page_url = data.next_page_url;
                        // this.prev_page_url = data.prev_page_url;
                        // this.current_page = data.current_page;
                        // this.renderPDF();
                    }.bind(this));
                } 
                else {
                    if (getPage != null){
                        $.getJSON(getPage, function (data) {
                            this.gridData = data;
                            // this.total = data.total;
                            // this.last_page =  data.last_page;
                            // this.next_page_url = (data.next_page_url == null) ? null : data.next_page_url + '&keyword=' +this.query;
                            // this.prev_page_url = (data.prev_page_url == null) ? null : data.prev_page_url + '&keyword=' +this.query;
                            // this.first_page_url = 'api/widget-data?page=1&keyword=' +this.query;
                            // this.last_page_url = 'api/widget-data?page=' + this.last_page + '&keyword=' +this.query;
                            // this.current_page = data.current_page;
                            // this.resetPageNumbers();
                            // this.renderPDF();
                        }.bind(this));
                    }
                }
            },
            // checkPage: function(page){
            //     return page == this.current_page;
            // },
            // resetPageNumbers: function(){
            //     this.pages = [];
            //     for (var i = 1; i <= this.last_page; i++) {
            //         this.pages.push(i);
            //     }
            // },
            checkUrlNotNull: function(url){
                return url != null;
            },
            // clearPageNumberInputBox: function(){
            //     return this.go_to_page = '';
            // },
            // pageInRange: function(){
            //     return this.go_to_page <= parseInt(this.last_page);
            // }
            renderPDF: function()
            {
                // console.log('render');
                var dms = document.querySelectorAll(".dm-box");
                // console.log(dms);
                dms.forEach(function(elm) {

                    var pdfUrl = elm.title;
                    // console.log(pdfUrl);

                    PDFJS.getDocument(pdfUrl).then(function(pdf) {
                      //for (var pageNum = 1; pageNum < pdf.numPages; ++pageNum) {
                        pdf.getPage(1).then(function(page) {
                          // you can now use *page* here

                          // var element = document.getElementById('test-pdf');
                          var element = elm;
                          var positionInfo = element.getBoundingClientRect();
                          
                          var canvas = document.createElement('canvas');
                          var context = canvas.getContext('2d');

                          

                          canvas.height = positionInfo.height;
                          canvas.width = positionInfo.width;

                          var viewport = page.getViewport(canvas.width / page.getViewport(1.0).width);

                          var renderContext = {
                            canvasContext: context,
                            viewport: viewport
                          };
                          page.render(renderContext);

                          while (element.firstChild) {
                            element.removeChild(element.firstChild);
                        }

                          element.appendChild(canvas);
                        });
                      //}
                    });
                });
            },
            confirmDelete: function(item)
            {
                var vm = this;
                swal({
                    title: "確定刪除此 DM？",
                    text: "此為不可逆操作",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                },
                function(){
                    // swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    vm.deleteItem(item);
                });


                // var x = confirm("確定刪除此 DM?");
                // if (x)
                //     this.deleteItem(item);
                // else
                //     return false;
            },
            deleteItem: function(item){
                this.$http.delete('/backend/dms/'+item.Id).then((response) => {
                    // this.changePage(this.pagination.current_page);
                    // toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    this.doSuccess("刪除 DM 成功!");
                    this.getData();

                });
            },
            doSuccess(title) {
                swal("Congrats!", title, "success");
            },
            doError() {
                this.alertError();
            },
            doConfirm(item) {
                var vm = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: true
                },
                function(){
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    // return true;
                    // vm.deleteItem(item);
                });
            }
        }
    }
</script>