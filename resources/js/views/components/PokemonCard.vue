<!-- @format -->

<template>
  <b-col class="mb-4" cols="3">
    <b-card
      border-variant="primary"
      :header="pokemon.name.toUpperCase()"
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
      <b-card-body>
        <b-button-group>
          <b-button
            :disabled="isNotAbleToLike === true"
            variant="outline-primary"
            @click="addToLikes(pokemon)"
            ><b-icon icon="hand-thumbs-up"></b-icon> Like</b-button
          >
          <b-button
            :disabled="isNotAbleToDislike === true"
            variant="outline-danger"
            @click="addToDislikes(pokemon)"
            ><b-icon icon="hand-thumbs-down"></b-icon> Dislike</b-button
          >
        </b-button-group>
      </b-card-body>
    </b-card>
  </b-col>
</template>

<script>
export default {
  props: {
    pokemon: {
      type: Object,
      required: true
    },
    likedPokemons: {
      type: Array,
      required: true
    },
    dislikedPokemons: {
      type: Array,
      required: true
    }
  },
  computed: {
    isNotAbleToLike() {
      const { name } = this.pokemon
      const pokemonFound = this.likedPokemons.find(
        ({ pokemon }) => pokemon === name
      )

      if (pokemonFound) return true
      return false
    },
    isNotAbleToDislike() {
      const { name } = this.pokemon
      const pokemonFound = this.dislikedPokemons.find(
        ({ pokemon }) => pokemon === name
      )

      if (pokemonFound) return true
      return false
    }
  },
  methods: {
    addToLikes(pokemon) {
      if (this.isNotAbleToLike === true) return
      this.$emit('addToLikes', pokemon)
    },
    addToDislikes(pokemon) {
      if (this.isNotAbleToDislike === true) return
      this.$emit('addToDislikes', pokemon)
    }
  }
}
</script>
