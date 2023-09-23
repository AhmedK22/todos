<template>
    <!--success message-->
  <div v-if="successMessage" class="alert alert-success">
    {{ successMessage }}
  </div>
    <!--/success message-->

  <div class="container bg-light mt-2">
    <div class="d-flex justify-content-between align-items-center w-100">
      <div>
        <h4>Todo List</h4>
        <div class="d-flex">
          <div class="me-2 bg-danger p-2 rounded-pill bg-opacity-75">
            <span class="px-2 ms-2 rounded-circle bg-danger">
              {{ remaining }}</span
            >
            Remaining
          </div>
          <div class="bg-success p-2 rounded-pill bg-opacity-75">
            <span class="px-2 ms-2 rounded-circle bg-success">
              {{ completed }}</span
            >
            Completed
          </div>
        </div>
      </div>
      <button
        @click="addModalForm()"
        class="btn h-50 btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#exampleModal"
      >
        ADD TASK
      </button>
    </div>

    <div class="mt-5">
      <div class="row my-2 w-100" v-for="(todo, index) in todos" :key="index">
        <div class="col-lg-3 border-bottom">
          <p>{{ todo.notes }}</p>
        </div>

        <div class="col-lg-3 border-bottom">
          <div
            class="d-flex align-items-center justify-content-center w-50 rounded px-2 bg-opacity-75"
          >
            <p
              v-if="todo.status == 'completed'"
              class="bg-success rounded w-100 text-center p-1"
            >
              {{ todo.status }}
            </p>
            <p
              v-if="todo.status == 'remaining'"
              class="bg-danger rounded w-100 text-center p-1"
            >
              {{ todo.status }}
            </p>
          </div>
        </div>

        <div class="col-lg-3 border-bottom d-flex justify-content-center">
          <div
            class="bg-success d-flex align-items-center justify-content-center w-50 rounded px-2 bg-opacity-75"
          >
            <span class="">{{ todo.date }}</span>
          </div>
        </div>

        <div class="col-lg-3 border-bottom d-flex justify-content-end">
          <button
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            @click="editModalForm(todo)"
            class="btn btn-primary me-2"
          >
            Edit
          </button>
          <button class="btn btn-danger" @click="deleteTodo(todo)">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add & edit Modal -->
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">
            {{ modalTitle }}
          </h1>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <AddForm
            :implementedAction="implementedAction"
            :editTodo="todo"
            v-on:formData="getFormData"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

import axios from "../axios";
import AddForm from "./AddForm.vue";

export default defineComponent({
  data() {
    return {
      todos: [],
      todo: {
        title: "",
        notes: "",
        date: "",
        status: "",
      },
      implementedAction: "addTodo",
      modalTitle: "Add Todos",
      successMessage: "",
      remaining: 0,
      completed: 0,
    };
  },
  mounted() {
    this.listTodo();
  },

  components: {
    AddForm,
  },
  methods: {
    listTodo() {
      axios
        .get("api/todos")
        .then((data) => {
          this.todos = data.data.todos;
          this.completed = 0;
          this.remaining = 0;
          this.todos.filter((todo) => {
            if (todo.status == "completed") {
              this.completed++;
            } else {
              this.remaining++;
            }
          });
          console.log(data.data.todos[0]);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getFormData(dataOfTodo) {
      if (dataOfTodo.implementedAction == "addTodo") {
        this.addTodo(dataOfTodo);
      } else {
        this.editTodos(dataOfTodo);
      }
    },
    editModalForm(editTodo) {
      this.modalTitle = "Edit Todos";
      this.implementedAction = "editTodo";
      this.todo = { ...editTodo };
    },
    addModalForm() {
      this.modalTitle = "Add Todos";
      this.implementedAction = "addTodo";
      this.todo = {
        title: "",
        notes: "",
        date: "",
      };
    },
    deleteTodo(deleteTodo) {
      if (window.confirm("Are you sure you want to delete?")) {
        axios
          .delete(`api/todos/${deleteTodo.id}`)
          .then((data) => {
            this.successMessage = "deleted success";
            this.listTodo();
          })
          .catch((error) => {
            this.successMessage = "";
            window.alert(error.response.data.message);
            console.log(error);
          });
      } else {
      }
    },
    addTodo(dataOfTodo) {
      axios
        .post("api/todos", dataOfTodo)
        .then((data) => {
          this.successMessage = "added todo  success";
          this.listTodo();
        })
        .catch((error) => {
          this.successMessage = "";
          window.alert(error.response.data.message);
        });
    },
    editTodos(dataOfTodo) {
      axios
        .put(`api/todos/${dataOfTodo.id}`, dataOfTodo)
        .then((data) => {
          this.successMessage = "edit todo  success";
          this.listTodo();
        })
        .catch((error) => {
          this.successMessage = "";
          window.alert(error.response.data.message);
        });
    },
  },
});
</script>

