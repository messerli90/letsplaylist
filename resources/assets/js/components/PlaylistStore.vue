<template>
  <form class="form" action="/playlists" method="post">
    <input type="hidden" name="_token" :value="csrfToken">
    <div class="form-group">
      <label for="game_key">Game</label>
      <select id="game_key" class="form-control" name="game_key">
        <option>Select a game</option>
      </select>
      <p class="help-block">Search for the game this playlist is about.</p>
    </div>
    <div class="form-group">
      <label for="playlist_key">Playlist ID</label>
      <div class="input-group">
        <span class="input-group-addon">https://www.youtube.com/playlist?list=</span>
        <input type="text" class="form-control" id="playlist_key" name="playlist_key" placeholder="PLwH1xJhcXG0dPGmbx35nhuzEacgKdjCUo" @change="check">
      </div>

      <p class="help-block">Paste the last part of the Youtube playlist url here.</p>
    </div>

    <button type="submit" class="btn btn-default">Save Playlist</button>
  </form>
</template>

<script>
export default {
  data () {
    return {
      game: {
        id: null,
        title: '',
        summary: '',
        cover: {}
      },
      playlist: {}
    }
  },
  props: ['csrfToken'],
  computed: {
    cover () {
      if (this.game.cover) {
        return 'https://images.igdb.com/igdb/image/upload/t_screenshot_med_2x/' + this.game.cover.cloudinary_id + '.jpg';
      }
      return '';
    }
  },
  methods: {
    check () {

    },
    formatGame (game) {
      if (game.loading) return game.text;

      var markup = ""

      if (game.cover) {
        markup += "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='https://images.igdb.com/igdb/image/upload/t_thumb/" + game.cover.cloudinary_id + ".jpg' /></div>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + game.name + "</div>";
      }


      if (game.summary) {
        var desc = game.summary.substring(0, 80);
        if (game.summary.length > 80) {
          desc += '...'
        }
        markup += "<div class='select2-result-repository__description'>" + desc + "</div>";
      }

      if (game.first_release_date) {
        var date = new Date(game.first_release_date);
        var release = (date.getMonth() + 1) + "/" + date.getDate() + "/" + date.getFullYear()

        markup += "<div class='select2-result-repository__statistics'>" +
        "<div class='select2-result-repository__forks'><i class='fa fa-clock-o'></i> Released " + release + "</div>" +
        "</div>";
      }

      markup += "</div>"

      return markup;
    },
    formatGameSelection (game) {
      this.game = game;
      return game.name;
    },

  },

  mounted () {
    $("#game_key").select2({
      placeholder: "Select an option",
      allowClear: true,
      theme: 'bootstrap',
      ajax: {
        url: "https://igdbcom-internet-game-database-v1.p.mashape.com/games/?fields=name,summary,cover,first_release_date",
        headers: {
          "X-Mashape-Key": "L7VtVwDYQhmshVYs8yLykGvACISqp1KlEK4jsn4HYxydBd5Cme",
          "Accept": "application/json"
        },
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            search: params.term
          };
        },
        processResults: function (data, params) {
          return {
            results: data
          };
        },
        cache: true
      },
      escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
      minimumInputLength: 3,
      templateResult: this.formatGame, // omitted for brevity, see the source of this page
      templateSelection: this.formatGameSelection // omitted for brevity, see the source of this page
    });
  }
}
</script>
