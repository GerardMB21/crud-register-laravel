<template>
  <div
    class="
      card
      w-[500px]
      bg-neutral
      text-neutral-content
      m-auto
      mt-8
    "
  >
    <form
      method="POST"
      v-on:submit.prevent="saveRegister()"
      class="
        card-body
        items-center
        text-center
        form-control
        gap-8
        p-4
        px-12
      "
    >
      <h2
        class="
          card-title
        "
      >
        Registrate
      </h2>
      <div
        class="
          w-full
          grid
          grid-cols-2
        "
      >
        <label
          class="
            label
            mr-2
          "
          for="name"
        >
          <span
            class="
              label-text
            "
          >
            Nombre:
          </span>
        </label>
        <input
          v-model="name"
          id="name"
          type="text"
          placeholder="Nombre"
          class="
            input
            input-bordered
            w-auto
            rounded-2xl
          "
        />
      </div>
      <div
        class="
          w-full
          grid
          grid-cols-2
        "
      >
        <label
          class="
            label
            mr-2
          "
          for="document"
        >
          <span
            class="
              label-text
            "
          >
            Documento de Identidad:
          </span>
        </label>
        <input
          v-model="document"
          id="document"
          type="number"
          placeholder="12345678"
          class="
            input
            input-bordered
            w-auto
            rounded-2xl
          "
        />
      </div>
      <div
        class="
          w-full
          grid
          grid-cols-2
        "
      >
        <label
          class="
            label
            mr-2
          "
          for="typeDocument"
        >
          <span
            class="
              label-text
            "
          >
            Tipo de documento:
          </span>
        </label>
        <select
          v-model="type_document"
          v-on:change="selectDocument($event)"
          id="typeDocument"
          class="
            select
            select-bordered
            w-auto
            rounded-2xl
          "
        >
          <option disabled selected>DNI o RUC</option>
          <option
            v-for="type_document in type_documents" :key="type_document.id"
          >
            {{ type_document.name_type }}
          </option>
        </select>
      </div>
      <div
        class="
          card-actions
          justify-end
        "
      >
        <button
          class="
            btn
            btn-success
            rounded-2xl
            px-8
          "
        >
          Crear
        </button>
      </div>
    </form>
  </div>
</template>
<script>
import axios from 'axios';

  export default {
    data() {
      return {
        name: '',
        document: undefined,
        type_document: 'DNI o RUC',
        type_document_id: 0,
        type_documents: []
      }
    },
    created() {
      axios.get('/type_documents')
        .then(response => {
          const { data } = response;

          this.type_documents = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    methods: {
      saveRegister() {
        const body = {
          name: this.name,
          document: this.document,
          type_document_id: this.type_document_id
        };

        axios.post('/registers', body)
          .then(response => {
            this.name = '';
            this.document = undefined;
            this.type_document = 'DNI o RUC';
            this.type_document_id = 0;
            console.log(response);
            window.location.reload();
          })
          .catch(error => {
            console.log(error);
          });
      },
      selectDocument(e) {
        const { target } = e;
        const { value } = target;

        const documents = this.type_documents;

        documents.map(document => {
          const {
            id,
            name_type
          } = document;

          if (value === name_type) {
            this.type_document_id = id;
          } else {
            this.type_document_id = 0;
          };
        });
      }
    }
  }
</script>