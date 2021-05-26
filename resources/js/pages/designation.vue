<template>
  <div class="container-fluid py-3">
    <div class="card">
      <div class="card-header">
        <strong>Designations</strong>
        <a
          @click.prevent="showModal(false)"
          href=""
          class="btn btn-success float-right"
        >
          <i class="fas mr-2 fa-plus"></i> Add Designation</a
        >
      </div>
      <table class="table table-striped">
        <thead>
          <th>SL</th>
          <th>Position</th>
          <th>Description</th>
          <th>Action (EDIT / DELETE)</th>
        </thead>
        <tbody>
          <tr
            v-for="(designation, index) in designations"
            :key="designation.id"
          >
            <td>{{ index + 1 }}</td>
            <td>{{ designation.position }}</td>
            <td>{{ designation.description }}</td>
            <td>
              <span>
                <a
                  @click.prevent="showModal(true, designation)"
                  href=""
                  class="btn btn-primary"
                  ><i class="fas fa-edit"></i
                ></a>
              </span>
              /
              <span>
                <a
                  href=""
                  @click.prevent="deleteDesignation(designation.id)"
                  class="btn btn-danger"
                  ><i class="fas fa-trash"></i
                ></a>
              </span>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <th>SL</th>
          <th>Position</th>
          <th>Description</th>
          <th>Action (EDIT / DELETE)</th>
        </tfoot>
      </table>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="designationModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modelTitleId"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="isUpdating" class="modal-title">Updating Designation</h5>
            <h5 v-else class="modal-title">Creating new Designation</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createNewDesignation">
            <div class="modal-body">
              <div class="mb-3">
                <label for="validationServerUsername">Position</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend3"
                      >@</span
                    >
                  </div>
                  <input
                    v-model="position"
                    type="text"
                    class="form-control"
                    :class="{ 'is-invalid': !!errors.position }"
                    id="validationServerUsername"
                    placeholder="position eg. waiter"
                    aria-describedby="inputGroupPrepend3"
                    required
                  />

                  <div v-if="!!errors.position" class="invalid-feedback">
                    {{ errors.position[0] }}
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="validationServerUsername">Description</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupPrepend3"
                      >@</span
                    >
                  </div>
                  <textarea
                    v-model="description"
                    rows="4"
                    placeholder="What is the position's description"
                    class="form-control"
                    :class="{ 'is-invalid': !!errors.description }"
                    required
                  ></textarea>

                  <div v-if="!!errors.description" class="invalid-feedback">
                    {{ errors.description[0] }}
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                Close
              </button>
              <button v-if="isUpdating" type="submit" class="btn btn-primary">
                Update
              </button>
              <button v-else type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      isUpdating: false,
      position: null,
      description: null,
      id: null,
    };
  },

  watch: {
    dialog(new_val) {
      if (new_val) {
        $("#designationModal").modal("hide");
        this.position = null
        this.description = null
        this.id = null
      }
    },
  },

  computed: {
    ...mapGetters({
      designations: "getDesignations",
      errors: "getErrors",
      dialog: "getCloseDialog",
    }),
  },

  mounted() {
    this.getDesignations();
  },

  methods: {
    ...mapActions({
      getDesignations: "getDesignationsAction",
      createDesignation: "createDesignationsAction",
      updateDesignation: "updateDesignationsAction",
      destroyDesignation: "deleteDesignationsAction",
    }),

    showModal(updating, designation) {
      this.isUpdating = updating;
      if (this.isUpdating) {
        this.id = designation.id;
        this.position = designation.position;
        this.description = designation.description;
      }
      $("#designationModal").modal("show");
    },

    createNewDesignation() {
      const data = {
        position: this.position,
        description: this.description,
      };

      if (this.isUpdating) {
        const updateData = {
          id: this.id,
          data: data,
        };
        this.updateDesignation(updateData);
      } else {
        this.createDesignation(data);
      }
    },

    deleteDesignation(id) {
      this.$swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.destroyDesignation(id);
          }
        });
    },
  },
};
</script>