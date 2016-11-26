<template>
  <div class="panel panel-default">
    <div class="panel-body">
      <form class="form-inline row">
        <div class="form-group col-sm-6">
          <label for="search" class="sr-only">Search</label>
          <input style="width: 100%;" type="text" class="form-control" id="search" placeholder="Search by title or channel" v-model="search" @keyup="changeSearch">
        </div>
        <div class="form-group col-sm-6">
          <label for="game"class="sr-only">Game</label>
          <select style="width: 100%;" id="game" class="form-control" @change.prevent="changeGame">
            <option value="">Select a game</option>
            <option v-for="game in games" :value="game.id">{{ game.title }}</option>
          </select>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import eventHub from '../events.js'
import debounce from 'debounce';

export default{
  data () {
    return {
      search: '',
      game: ''
    }
  },

  props: ['games'],

  created() {
    this.changeSearch = debounce(this.changeSearch, 500);
  },

  methods: {
    changeSearch (e) {
      eventHub.$emit('filters.search', e.target.value)
    },
    changeGame () {
      eventHub.$emit('filters.game', this.game)
      eventHub.$emit('banner.game', this.game)
    }
  },

  mounted () {
    var self = this
    $("#game").select2({
      theme: 'bootstrap'
    });

    $("#game").change(function(e) {
      self.game = e.target.value
      self.changeGame()
    });
  }
}
</script>
