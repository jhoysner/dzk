<template>
	<div>
		<ul class="pagination d-flex justify-content-center pt-20 pb-20">
      <li class="page-item"><a class="page-link" href="#" v-if="pagination.current_page > 1"@click.prevent="changePage(pagination.current_page - 1)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>
      <li class="page-item" v-for="page in pagesNumber" :class="[page == isActived ? 'active' : '']">
        <a class="page-link" href="#" @click.prevent="changePage(page)">
          {{ page }}
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="#" v-if="pagination.current_page < pagination.last_page" @click.prevent="changePage(pagination.current_page + 1)">
        	<i class="fa fa-caret-right" aria-hidden="true"></i>
        </a>
      </li>
    </ul>
	</div>
</template>

<script>
import Bus from './EventBus.js';

	export default {
		props: ['pagination'],
		data() {
			return {
       offset: 2,
			}
		},

		computed: {
			isActived() {
            return this.pagination.current_page; //Función para la pagina actual.
        },

        pagesNumber() {
            if(!this.pagination.to) { //Si no hay pagina adonde ir (Más de una) retorna array vacío.
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if(from < 1) { //Si "from" es menor a 1, no se puede. No existe una página menor a 1.
                from = 1; //Así que siempre será 1.
            }

            var to = from + (this.offset * 2); 

            if(to >= this.pagination.last_page) { //Si "to" es mayor, al maximo de páginas que existe en laravel.
                to = this.pagination.last_page; //Le decimos que el maximo es el q dice laravel.
            }

            let pageArray = []; //Definimos las paginas en un array.

            while (from <= to) { //Recorremos "from" hasta que llegue a la ultima en "to"
                pageArray.push(from); //Mientras recorre, la añadimos al pagesArray.
                from++; //Y aumentamos el numero de páginas que va avanzando en from.
            }

            return pageArray; //Por último, retornamos la data del n° de páginas guardada en pagesArray.
        },
		},

		methods: {
    	changePage(page) {
        this.pagination.current_page = page;
        Bus.$emit('change_page', page);
  		},
    }
	}
</script>