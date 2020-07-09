<template>
  <div class="container">

    <input type="text" placeholder="Filter by Channel name & date" v-model="filter" />

    <br>

   <table class="table">
    <thead>
      <tr>
        <th>Channel Id</th>
        <th>Channel Name</th>
        <th>Program Title</th>
        <th>Program Start Date</th>
        <th>Program Short description</th>
        <th>Program age limit</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in filteredRows" :key="`program-${index}`">
        <td v-html="highlightMatches(row.channel_id)"></td>
        <td v-html="highlightMatches(row.channelName)"></td>
        <td v-html="highlightMatches(row.title)"></td>
        <td v-html="highlightMatches(row.start_datetime)"></td>
        <td v-html="highlightMatches(row.short_description)"></td>
        <td v-html="highlightMatches(row.age_limit)"></td>
      </tr>
    </tbody>
  </table>

  
    </div>
</template> 

<script>

export default {
    props: ['programs'],
	components: {
	},
    data() { 
      return {
        filter: "",
    }
  },
  methods: {
    highlightMatches(text) {
      const matchExists = text
        .toLowerCase()
        .includes(this.filter.toLowerCase());
      if (!matchExists) return text;

      const re = new RegExp(this.filter, "ig");
      return text.replace(re, matchedText => `<strong>${matchedText}</strong>`);
    }
  },
  computed: {
    filteredRows() {
      return this.programs.filter(row => {
        let channelName = row.channelName.toLowerCase();
        let start_datetime = row.start_datetime.toLowerCase();

        let searchTerm = this.filter.toLowerCase();

        return (
            channelName.includes(searchTerm) || start_datetime.includes(searchTerm)
        );
      });
    }
  }
}
</script>

<style scoped>
#vue-table {
  margin: 2em 0;
  
  a {
    font-weight: bold;
    text-decoration: none;  
    
    &.active {
      font-weight: bold;
      color: black;
      text-decoration: underline;
    }
  }
}
</style>