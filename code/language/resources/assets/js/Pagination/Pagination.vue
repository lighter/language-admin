<template>
    <nav class="pagination" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
            <li>
                <a class="pagination-link" aria-label="Goto page 1">{{ this.firstPageStr }}</a>
            </li>

            <!--<li>-->
            <!--<a class="pagination-link" aria-label="Goto page 45">45</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a>-->
            <!--</li>-->
            <!--<li>-->
            <!--<a class="pagination-link" aria-label="Goto page 47">47</a>-->
            <!--</li>-->


            <li v-for="index in this.allPages">
                <a class="pagination-link" :class="{ 'is-current': (index === this.current_page) }">{{ index
                    }}</a>
            </li>

            <li>
                <a class="pagination-link" aria-label="Goto page 86">{{ this.lastPageStr }}</a>
            </li>
        </ul>
    </nav>
</template>

<script>
  export default {
    name: "Pagination",
    data() {
      return {
        allPages: [],
        current_page: this.paginationData.current_page,
        last_page: this.paginationData.last_page
      }
    },
    props: {
      paginationData: {
        type: Object,
        default: () => {
          return {
            current_page: 0,
            per_page: 10,
            total: 0,
            last_page: 0,
          };
        },
      },
      showPageCount: {
        type: Number,
        default: 5,
      },
      lastPageStr: {
        type: String,
        default: 'Last Page',
      },
      firstPageStr: {
        type: String,
        default: 'First Page',
      }
    },
    methods: {
      getPagination() {
        let all_page = [];

        let last = (this.paginationData.total_page < this.showPageCount) ? this.paginationData.total_page : this.showPageCount;

        for (let i = 1; i <= last; i++) {
          all_page.push(i);
        }

        let m = Math.round(this.showPageCount / 2);
        let n = this.paginationData.current_page - m;

        if (n < 0) n = 0;
        else n = this.paginationData.current_page - m;

        for (let i in all_page) {
          all_page[i] += n;
        }

        return all_page;
      }
    },
    watch: {
      paginationData: function (val) {
        this.paginationData = val;
        this.allPages = this.getPagination();
        this.current_page = this.paginationData.current_page;
        this.last_page = this.paginationData.last_page;
      }
    }
  }
</script>

<style scoped>

</style>
