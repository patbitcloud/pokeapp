<!-- @format -->

<template>
  <div>
    <b-form-input
      size="lg"
      class="mt-4"
      v-model.trim="searchPokemon"
      @input="searchForPokemon"
      placeholder="Search pokemon here..."
    ></b-form-input>
    <b-overlay :show="isRetrieving" rounded="sm">
      <b-row class="mt-4">
        <pokemon-card
          v-for="(pokemon, i) in pokemons"
          :pokemon="pokemon"
          :key="i"
          :likedPokemons="likedPokemons"
          :dislikedPokemons="dislikedPokemons"
          @addToLikes="addToLikes"
          @addToDislikes="addToDislikes"
        />
        <pagination
          :isFirstPage="isFirstPage"
          :isRetrieving="isRetrieving"
          :loadingPrev="loadingPrev"
          :loadingNext="loadingNext"
          @previous="previousPage"
          @next="nextPage"
        />
        <b-col class="mb-4"> </b-col>
      </b-row>
    </b-overlay>
  </div>
</template>

<script>
import PokemonCard from './components/PokemonCard.vue'
import Pagination from './components/Pagination.vue'
import { debounce } from 'lodash'
import http from '../utils/http'

export default {
  components: { PokemonCard, Pagination },
  data() {
    return {
      pokemons: [],
      searchPokemon: '',
      likedPokemons: [],
      dislikedPokemons: [],
      next: null,
      previous: null,
      text: '',
      totalPokemon: 0,
      isRetrieving: true,
      loadingPrev: false,
      loadingNext: false
    }
  },
  computed: {
    isFirstPage() {
      return this.previous === null
    }
  },
  methods: {
    //save to user_pokemon_likes table
    async addToLikes({ name, url }) {
      try {
        const { data } = await http.post('/pokemon/add-to-likes', { name, url })
        this.init()
        alert(data.message)
      } catch (error) {
        if (error.response.status === 422) {
          alert(error.response.data.message)
        }
      }
    },
    //save to user_pokemon_dislikes table
    async addToDislikes({ name, url }) {
      try {
        const { data } = await http.post('/pokemon/add-to-dislikes', {
          name,
          url
        })
        this.init()
        alert(data.message)
      } catch (error) {
        if (error.response.status === 422) {
          alert(error.response.data.message)
        }
      }
    },
    //pagination previous page button
    async previousPage() {
      this.isRetrieving = true
      this.loadingPrev = true
      const { data } = await http.get(this.previous)
      const { results, next, previous, count } = data
      this.pokemons = results
      this.next = next
      this.previous = previous
      this.totalPokemon = count
      this.isRetrieving = false
      this.loadingPrev = false
    },
    //pagination next page button
    async nextPage() {
      this.isRetrieving = true
      this.loadingNext = true
      const { data } = await http.get(this.next)
      const { results, next, previous, count } = data
      this.pokemons = results
      this.next = next
      this.previous = previous
      this.totalPokemon = count
      this.isRetrieving = false
      this.loadingNext = false
    },

    //search pokemon area (not finished)
    searchForPokemon() {
      this.search(this)
    },
    search: debounce(async vm => {
      // const { data } = await http.get(
      //   `/pokemon/pokemon-name?search=${vm.searchPokemon}`
      // )
      vm.pokemons = data.data
    }, 250),
    //retrieve and display all pokemon data from api
    async retrievePokemon() {
      const { data } = await http.get('https://pokeapi.co/api/v2/pokemon')
      const { results, next, previous, count } = data
      this.pokemons = results
      this.next = next
      this.previous = previous
      this.totalPokemon = count
      this.isRetrieving = false
    },
    //emit function on user likes and dislikes button
    async retrieveUserPokemon() {
      const { data } = await http.get('/pokemon/user')
      const { likedPokemons, dislikedPokemons } = data

      this.likedPokemons = likedPokemons
      this.dislikedPokemons = dislikedPokemons
    },
    async init() {
      await Promise.all([this.retrievePokemon(), this.retrieveUserPokemon()])
    }
  },
  async created() {
    this.init()
  }
}
</script>
