<template>
  <div
    class="
      overflow-x-auto
      mt-8
    "
  >
    <table
      class="
        table
        w-auto
        m-auto
        mb-8
      "
    >
      <!-- head -->
      <thead>
        <tr>
          <th>
            Id
          </th>
          <th>
            Nombre
          </th>
          <th>
            Documento
          </th>
          <th>
            Tipo de Documento
          </th>
          <th
            class="
              flex
              items-center
              justify-center
            "
          >
            opciones
          </th>
        </tr>
      </thead>
      <tbody
        v-for="register in registers" :key="register.id"
      >
        <!-- row 1 -->
        <tr>
          <th>{{ register.id }}</th>
          <td>{{ register.name }}</td>
          <td>{{ register.document }}</td>
          <td>{{ register.type_document }}</td>
          <td
            class="
              flex
              items-center
              justify-center
            "
          >
            <div
              class="btn-group"
            >
              <label
                v-on:click="edit(register)"
                for="edit-modal"
                class="
                  btn
                  btn-info
                "
              >
                <i class="fa-solid fa-pen-to-square" style="color: #fcfcfc;"></i>
              </label>
              <label
                v-on:click="eliminar(register.id)"
                for="delete-modal"
                class="
                  btn
                  btn-error
                "
              >
                <i class="fa-solid fa-trash" style="color: #fcfcfc;"></i>
            </label>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <input
      type="checkbox"
      id="edit-modal"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <div
          class="
            card
            w-[400px]
            bg-neutral
            text-neutral-content
            m-auto
            mt-8
          "
        >
          <form
            method="POST"
            v-on:submit.prevent="editRegister()"
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
              Editar Registro
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
                  btn-info
                  rounded-2xl
                  px-8
                "
              >
                Actualizar
              </button>
            </div>
          </form>
        </div>
        <div class="modal-action">
          <label
            for="edit-modal"
            class="
              btn
              btn-warning
            "
          >
            Cancelar
          </label>
        </div>
      </div>
    </div>
    <input
      type="checkbox"
      id="delete-modal"
      class="modal-toggle"
    />
    <div class="modal">
      <div class="modal-box">
        <p class="py-4">Estas seguro de eliminar el registro {{ this.id }}</p>
        <div class="modal-action">
          <label
            for="delete-modal"
            class="
              btn
              btn-warning
            "
          >
            cancelar
          </label>
          <label
            v-on:click="eliminarRegister()"
            for="delete-modal"
            class="
              btn
              btn-error
            "
          >
            Eliminar
          </label>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      registers: [],
      id: 0,
      name: '',
      document: undefined,
      type_document: 'DNI o RUC',
      type_document_id: 0,
      type_documents: []
    }
  },
  created() {
    axios.get('/registers')
      .then(response => {
        const { data } = response;

        data.map(register => {
          const {
            id,
            type_document_id
          } = register;

          axios.get(`/type_documents/${type_document_id}`)
            .then(response => {
              const { data } = response;
              const registers = this.registers;

              registers.map(item => {
                if (item.id === id) {
                  item.type_document = data.name_type;
                };
              });
            })
            .catch(error => {
              console.log(error);
            });
        });

        this.registers = data;
      })
      .catch(error => {
        console.log(error);
      });

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
    edit(register) {
      const {
        id,
        name,
        document,
        type_document,
        type_document_id
      } = register;

      this.id = id;
      this.name = name;
      this.document = document;
      this.type_document = type_document;
      this.type_document_id = type_document_id;
    },
    eliminar(id) {
      this.id = id;
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
    },
    editRegister() {
      const body = {
        name: this.name,
        document: this.document,
        type_document_id: this.type_document_id
      };

      axios.put(`/registers/${this.id}`, body)
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
    eliminarRegister() {
      axios.delete(`/registers/${this.id}`)
        .then(response => {
          console.log(response);
          window.location.reload();
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
}
</script>