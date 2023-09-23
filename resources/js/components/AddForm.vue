<template>
  <form @submit.prevent="submitForm">

        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input type="text" class="form-control" id="title" v-model="formData.title">
        </div>
        <div class="mb-3">
          <label for="notes" class="form-label">Notes</label>
          <textarea class="form-control" id="notes" rows="3" v-model="formData.notes"></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">status</label>
        <select class="form-select" aria-label="Default select example" v-model="formData.status">
           
            <option value="remaining">Remaining</option>
            <option value="completed">Completed</option>

          </select>
          </div>
        <div class="mb-3 form-check">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" v-model="formData.date">
        </div>
        <button type="submit" class="mt-2 btn btn-primary" data-bs-dismiss="modal">Submit</button>
  </form>

</template>
<script>
import { defineComponent } from "vue";
export default defineComponent({
  data() {
    return {
      formData: this.$props.editTodo,
      newimplementedAction: this.$props.implementedAction
    };
  },
  props:['editTodo','implementedAction'],

  methods: {
    submitForm() {
        this.formData['implementedAction'] = this.newimplementedAction
        console.log(  this.formData)
        this.$emit('formData', this.formData)
        this.$props.editTodo={
        title: "",
        notes: "",
        date: "",
        status: "",
      }
    },
  },

  watch:{
    editTodo:function (value) {
        // console.log('from watch')
        this.formData = value
        // console.log(value)
    },
    implementedAction:function (value) {
        console.log('from watch')
        console.log( this.newimplementedAction)
        this.newimplementedAction = value

    }
  }
});
</script>

