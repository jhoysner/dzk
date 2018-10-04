<template>
    <div>
      <Header/>
      <star-hero :title="title" :subtitle="subtitle" />
      <Nav/>
        <div class="content">
          <router-view></router-view>
        </div>
      <!--<Foot/> -->
    </div>
</template>

<script>
import Header from './layouts/Header.vue';
import starHero from './layouts/section_star_hero.vue';
import Foot from './layouts/Footer.vue';
import Nav from './layouts/Navigator.vue';

import Bus from '../utilities/EventBus';

    export default {
      name: 'Main',
      components: {
        Header, starHero, Nav, Foot
      },
      data() {
        return {
          title: '',
          subtitle: ''
        }
      },
        created() {
            console.log('Component mounted.')
            Bus.$on('jumbo-msg', (data) => {
        			this.title = data.title;
        			this.subtitle = data.subtitle;
        		});

        }
    }
</script>
