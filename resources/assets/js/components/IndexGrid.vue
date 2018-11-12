<template>
    <div class="row">
        <div class="col-lg-12">
            <!-- <form id="search" class="form-horizontal">
                <label for="query" class="col-sm-1 control-label">搜尋</label>
                <div class="col-sm-2">
                    <input name="query" v-model="query" @keyup="search(query)" class="form-control">
                </div>
            </form>
            <hr> -->

            <form id="search" class="form-inline">
                <div class="form-group" v-if="modelName == 'products'">
                    <select name="category_id" class="form-control" v-model="query" @change="search(query)">
                        <option value="">-- 商品類別 --</option>
                        <option v-for="(key, value) in selects['categories']" :value="value">{{value}}</option>
                    </select>
                </div>
                <div class="form-group" v-if="modelName == 'products'">
                    <select name="series_id" class="form-control" v-model="query" @change="search(query)">
                        <option value="">-- 商品系列 --</option>
                        <option v-for="(key, value) in selects['series']" :value="value">{{value}}</option>
                    </select>
                </div>

                <div class="form-group" v-if="modelName == 'products'">
                    <select name="style_id" class="form-control" v-model="query" @change="search(query)">
                        <option value="">-- 款式系列 --</option>
                        <option v-for="(key, value) in selects['styles']" :value="value">{{value}}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="sr-only" for="query">Email address</label>
                    <input type="text" class="form-control" id="query" name="query" v-model="query" @keyup="search(query)" placeholder="名稱">
                </div>
            </form>

            <!-- <div class="pull-right">
                {{ total }} Total Results
            </div> -->
            <section class="panel">
                <div class="panel-body">

                    <table class="table table-bordered table-striped">

                        <thead>
                        <tr>
                            <!-- <th v-show:="">圖檔</th> -->
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
                            <!-- <td style="width: 16%;" v-show:="">
                                <div class="img-box">
                                    <img v-bind:src="'/' + row.ImgURL">
                                </div>
                            </td> -->
                            <td v-for="column in gridColumns">
                                <template v-if="column == '顯示於前台'">
                                    <input type="checkbox" :checked="row[column] == 1" @click="toggleOnShowing(row.Id)">
                                </template>
                                <template v-else-if="column == '設為推薦'">
                                    <input type="checkbox" :checked="row[column] == 1" @click="toggleIsRecommended(row.Id)">
                                </template>
                                <template v-else-if="column.includes('內容')">
                                    <div v-html="pureText(nl2br(row[column])).substring(0,30) + ' ...'">
                                    </div>
                                </template>
                                <template v-else-if="column.includes('圖')">
                                    <div class="img-box">
                                        <img v-bind:src="row.ImgURL" style="width: 150px; height: auto;">
                                    </div>
                                </template>
                                <template v-else-if="column.includes('影')">
                                    <div class="img-box">
                                        <iframe v-bind:src="row.VideoURL" frameborder="0"></iframe>
                                    </div>
                                </template>
                                <template v-else>
                                    {{ row[column] }}
                                </template>
                            </td>
                            <!-- <td>
                                {{ row.編號 }}
                            </td> -->
                            <!-- <td>
                                {{ row.上架日期 }}
                            </td>
                            <td>
                                {{ row.下架日期 }}
                            </td>
                            <td>
                                {{ row.排序 }}
                            </td>
                            <td>
                                {{ row.狀態 }}
                            </td>
                            <td>
                                {{ row.上次編輯者 }}
                            </td>
                            <td>
                                {{ row.上次編輯時間 }}
                            </td> -->
                            <td >
                                <a v-bind:href="'/' + modelName + '/' + row.Id + '/edit'">
                                    <button type="button" class="btn btn-default">
                                        <template v-if="modelName.indexOf('en') >= 0">
                                            Edit
                                        </template>
                                        <template v-else>
                                            編輯
                                        </template>
                                    </button>
                                </a>
                                <button class="btn btn-danger" @click.prevent="confirmDelete(row)">
                                    <template v-if="modelName.indexOf('en') >= 0">
                                        Delete
                                    </template>
                                    <template v-else>
                                        刪除
                                    </template>
                                </button>
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
        data: function () {
            return {
                modelName: '',
                query: '',
                gridColumns: [],

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
                sortKey: '',
                selects: [],
            }
        },
        filters: {
            nl2br: function(value) {
                return (value + '')
                    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
            },
            pureText: function(value) {
                // console.log(value);
                return value.replace(/<img[^>]*>/g, '');
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
                this.modelName = location.pathname.split('/')[1];
                console.log(this.modelName);
                $.getJSON('/api/' + this.modelName + '-data', function (data) {
                    this.gridColumns = data.headers;
                    this.gridData = data.data;
                    if(this.modelName == 'products')
                    {
                        this.selects = data.selects;
                        console.log(this.selects['categories']);
                    }
                    // this.total = data.total;
                    // this.last_page =  data.last_page;
                    // this.next_page_url = data.next_page_url;
                    // this.prev_page_url = data.prev_page_url;
                    // this.current_page = data.current_page;
                    // this.first_page_url = 'api/widget-data?page=1';
                    // this.last_page_url = 'api/widget-data?page=' + this.last_page;
                    // this.setPageNumbers();
                }.bind(this));
            },
            // setPageNumbers: function(){
            //     for (var i = 1; i <= this.last_page; i++) {
            //         this.pages.push(i);
            //     }
            // },
            getData: function (request){
                console.log(request);
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
                        getPage = '/api/' + this.modelName + '-data?' +
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
                        getPage = '/api/' + this.modelName + '-data?' +
                                  // 'page=' + request +
                                  '&column=' + this.sortKey +
                                  '&direction=' + this.sortOrder +
                                  '&keyword=' + this.query;
                        break;
                }
                console.log(getPage);
                if (this.query == '' && getPage != null){
                    $.getJSON(getPage, function (data) {
                        this.gridData = data.data;
                        // this.total = data.total;
                        // this.last_page =  data.last_page;
                        // this.next_page_url = data.next_page_url;
                        // this.prev_page_url = data.prev_page_url;
                        // this.current_page = data.current_page;
                    }.bind(this));
                }
                else {
                    if (getPage != null){
                        $.getJSON(getPage, function (data) {
                            this.gridData = data.data;
                            // this.total = data.total;
                            // this.last_page =  data.last_page;
                            // this.next_page_url = (data.next_page_url == null) ? null : data.next_page_url + '&keyword=' +this.query;
                            // this.prev_page_url = (data.prev_page_url == null) ? null : data.prev_page_url + '&keyword=' +this.query;
                            // this.first_page_url = 'api/widget-data?page=1&keyword=' +this.query;
                            // this.last_page_url = 'api/widget-data?page=' + this.last_page + '&keyword=' +this.query;
                            // this.current_page = data.current_page;
                            // this.resetPageNumbers();
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
            confirmDelete: function(item)
            {
                var vm = this;
                swal({
                    title: "確定刪除此筆記錄？",
                    text: "此為不可逆操作",
                    icon: "warning",
                    dangerMode: true,
                    buttons: ["取消", "刪除"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        vm.deleteItem(item);
                    } else {
                        swal("記錄未被刪除");
                    }
                });


                // var x = confirm("確定刪除此 Banner?");
                // if (x)
                //     this.deleteItem(item);
                // else
                //     return false;
            },
            deleteItem: function(item){
                axios
                // .delete('/api/' + this.modelName + '/'+item.Id)
                .delete('/' + this.modelName + '/'+item.Id, {
                    data: {
                        id : item.Id,
                    }
                })
                .then((response) => {
                    // this.changePage(this.pagination.current_page);
                    // toastr.success('Item Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    this.doSuccess("刪除記錄成功!");
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
            },
            toggleOnShowing(id) {
                axios.get('/api/' + this.modelName + '/' + id + '/toggle-on-showing').then((response) => {
                    console.log(response.data);
                    // this.getData();
                });
            },
            toggleIsRecommended(id) {
                axios.get('/api/' + this.modelName + '/' + id + '/toggle-is-recommended').then((response) => {
                    console.log(response.data);
                    // this.getData();
                });
            },
            nl2br: function(value) {
                return (value + '')
                    .replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br/>' + '$2');
            },
            pureText: function(value) {
                // console.log(value);
                return value.replace(/<img[^>]*>/g, '');
            }
        }
    }
</script>