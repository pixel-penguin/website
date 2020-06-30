<template>
  <div style="width:100%; z-index:100">
    <form style="width:100%">
      <!--<input style="width:100%" type="search" class="form-control" name="q" id="q" placeholder="Search..." required>-->
      <vue-autosuggest
        v-model="searchKeyword"
        @keyup="search"
        class="form-control"
        :suggestions="searchResults"
        :input-props="{id:'autosuggest__input', placeholder:'Search?'}"
        @selected="selectHandler"
      >
      <template slot-scope="{suggestion}">
        <a :href="'/product/'+suggestion.item.link_name"><span class="my-suggestion-item">{{suggestion.item.name}}</span></a>
    </template>
      </vue-autosuggest>
      <button class="btn" type="submit">
        <i class="icon-magnifier"></i>
      </button>
    </form>
  </div>
</template>

<script>
   
    export default {
        data(){
            return{
                loading: null,
                searchKeyword: null,

                searchResults: [],
                
                cancelSource:null
            }
        },
        
        mounted() {
            const self = this;

            


        },
        methods:{
            renderSuggestion(suggestion) {
                return suggestion.name;
            },
            selectHandler(e){
                //console.log(e);

                window.location = '/product/'+e.item.link_name;
            },
            search(){
                const self = this;
                
                
                this.cancelSearch();
                this.cancelSource = Vue.axios.CancelToken.source();

                Vue.axios
                    .post('/json/search/products', {
                        search:self.searchKeyword                        
                    },
                    {
                        cancelToken: this.cancelSource.token
                    })
                    .then(response => {
                    //console.log(response);

                        var data = response.data;

                        self.searchResults = [{
                            data: data.data
                        }];

                        self.loading = false;
                    })
                    .catch(error => {
                        console.log(error);
                        self.loading = false;
                    });
            },

            cancelSearch() {
                if (this.cancelSource) {
                    this.cancelSource.cancel("Start new search, stop active search");
                    console.log("cancel request done");
                }
            }
        }

    }

</script>