<!-- @format -->

<template>
  <div class="row">
    <div class="col-md-4 mt-4" style="position:relative;left: 200px;">
      <h3 style="color: white;">LIKED POKEMON:</h3>

      <ul>
        <li v-for="pokemon in my_pokemon_likes" :key="pokemon.id">
          <b-col class="mb-4">
            <b-card
              border-variant="primary"
              :header="pokemon.pokemon.toUpperCase()"
              header-bg-variant="danger"
              header-text-variant="white"
              align="center"
            >
              <b-card-text>
                <!-- <router-link ></router-link> -->
                <b-img
                  src="/assets/img/pokeball.png"
                  class="w-20 h-20"
                  center
                  fluid
                  alt="Fluid image"
                ></b-img>
              </b-card-text>
            </b-card>
          </b-col>
        </li>
      </ul>
    </div>

    <div class="col-md-4 mt-4" style="position:relative;left: 200px;">
      <h3 style="color: white;">DISLIKED POKEMON:</h3>

      <ul>
        <li v-for="pokemon in my_pokemon_dislikes" :key="pokemon.id">
          <b-col class="mb-4">
            <b-card
              border-variant="primary"
              :header="pokemon.pokemon.toUpperCase()"
              header-bg-variant="danger"
              header-text-variant="white"
              align="center"
            >
              <b-card-text>
                <!-- <router-link ></router-link> -->
                <b-img
                  src="/assets/img/pokeball.png"
                  class="w-20 h-20"
                  center
                  fluid
                  alt="Fluid image"
                ></b-img>
              </b-card-text>
            </b-card>
          </b-col>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import http from '../utils/http'
export default {
  data() {
    return {
      my_pokemon_likes: [],
      my_pokemon_dislikes: []
    }
  },
  methods: {
    //retrieve and display all user pokemon likes
    async MyPokemonLikes() {
      const { data } = await http.get('/pokemon/my-pokemon-likes')
      this.my_pokemon_likes = data
    },
    //retrieve and display all user pokemon dislikes
    async myPokemonDislikes() {
      const { data } = await http.get('/pokemon/my-pokemon-dislikes')
      this.my_pokemon_dislikes = data
    }
  },
  mounted() {
    this.MyPokemonLikes()
    this.myPokemonDislikes()
  }
}
</script>

<style lang="scss" scoped></style>
