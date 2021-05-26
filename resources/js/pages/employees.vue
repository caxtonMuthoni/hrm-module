<template>
  <div class="container-fluid py-3">
    <div class="card">
      <div class="card-header">
        <strong>Employees</strong>
        <a
          @click.prevent="showModal(false)"
          href=""
          class="btn btn-success float-right"
        >
          <i class="fas mr-2 fa-plus"></i> Add Employee</a
        >
      </div>
      <table class="table table-striped">
        <thead>
          <th>SL No</th>
          <th>Photograph</th>
          <th>Name</th>
          <th>Position</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Duty Type</th>
          <th>Send SMS</th>
          <th>Action (EDIT / DELETE)</th>
        </thead>
        <tbody>
          <tr v-for="(employee, index) in employees" :key="employee.id">
            <td>{{ index + 1 }}</td>
            <td>
              <img :src="employee.user.photo" alt="Photo" class="avatar" />
            </td>
            <td>{{ employee.user.name }}</td>
            <td>{{ employee.designation.position }}</td>
            <td>{{ employee.phonenumber }}</td>
            <td>{{ employee.user.email }}</td>
            <td>{{ employee.duty_type }}</td>
            <td><a @click.prevent="showSMSModal(employee)" href="" class="btn btn-info"><i class="fas fa-share    "></i></a></td>
            <td>
              <span>
                <a
                  @click.prevent="showModal(true, employee)"
                  href=""
                  class="btn btn-primary"
                  ><i class="fas fa-edit"></i
                ></a>
              </span>
              /
              <span>
                <a
                  @click.prevent="deleteEmployee(employee.id)"
                  href=""
                  class="btn btn-danger"
                  ><i class="fas fa-trash"></i
                ></a>
              </span>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <th>SL No</th>
          <th>Photograph</th>
          <th>Name</th>
          <th>Position</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Duty Type</th>
          <th>Send SMS</th>
          <th>Action (EDIT / DELETE)</th>
        </tfoot>
      </table>
    </div>

    
    <!-- SMS Modal -->
    <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="smsEmployee" class="modal-title">Send Sms to <strong>{{ smsEmployee.user.name }}</strong></h5>
            <h5 v-else class="modal-title">Send Sms</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form @submit.prevent="sendSMS">
            <div class="modal-body">
            <textarea v-model="sms" class="form-control" placeholder="Type message ..."></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
          </form>
        </div>
      </div>
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
            <h5 v-if="isUpdating" class="modal-title">
              Updating Employee Details
            </h5>
            <h5 v-else class="modal-title">Creating new Employee</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createAndUpdateEmployee">
            <div class="modal-body row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="validationServerUsername">Employee name</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-user-check"></i
                      ></span>
                    </div>
                    <input
                      v-model="name"
                      type="text"
                      class="form-control"
                      id="validationServerUsername"
                      placeholder="What is the employee's name ?"
                      aria-describedby="inputGroupPrepend3"
                      required
                      :class="{ 'is-invalid': !!employeeErrors.name }"
                    />
                    <div v-if="!!employeeErrors.name" class="invalid-feedback">
                      {{ employeeErrors.name[0] }}
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="validationServerUserPhone">Employee Phone</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-phone"></i
                      ></span>
                    </div>
                    <input
                      v-model="phonenumber"
                      type="text"
                      class="form-control"
                      id="validationServerUserPhone"
                      placeholder="Employee's phone number ?"
                      aria-describedby="inputGroupPrepend3"
                      required
                      :class="{ 'is-invalid': !!employeeErrors.phonenumber }"
                    />
                    <div
                      v-if="!!employeeErrors.phonenumber"
                      class="invalid-feedback"
                    >
                      {{ employeeErrors.phonenumber[0] }}
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label for="validationServerEmail">Employee Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-envelope"></i
                      ></span>
                    </div>
                    <input
                      v-model="email"
                      type="email"
                      class="form-control"
                      id="validationServeeEmail"
                      placeholder="Employee's email adress ?"
                      aria-describedby="inputGroupPrepend3"
                      required
                      :class="{ 'is-invalid': !!employeeErrors.email }"
                    />
                    <div v-if="!!employeeErrors.email" class="invalid-feedback">
                      {{ employeeErrors.email[0] }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="mb-3">
                  <label for="validationServerUsername">Position</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-file-prescription"></i
                      ></span>
                    </div>
                    <select
                       v-model="designation_id"
                      class="form-control"
                      id="selectposition"
                      :class="{ 'is-invalid': !!employeeErrors.designation_id }"
                      required
                    >
                      <option value="" disabled selected>
                        Select employee position
                      </option>
                      <option v-for="designation in designations" :key="designation.id" :value="designation.id">{{ designation.position }}</option>
                    </select>
                    />
                    <div
                      v-if="!!employeeErrors.designation_id"
                      class="invalid-feedback"
                    >
                      {{ employeeErrors.designation_id[0] }}
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="selectduty">Duty type</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-times"></i
                      ></span>
                    </div>
                    <select
                      v-model="duty_type"
                      class="form-control"
                      id="selectduty"
                      :class="{ 'is-invalid': !!employeeErrors.duty_type }"
                      required
                    >
                      <option value="" disabled selected>
                        Select employee duty type
                      </option>
                      <option value="Part time">Part time</option>
                      <option value="Full time">Full time</option>
                    </select>

                    <div
                      v-if="!!employeeErrors.duty_type"
                      class="invalid-feedback"
                    >
                      {{ employeeErrors.duty_type[0] }}
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="photo">Employee Photo</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupPrepend3"
                        ><i class="fas fa-image"></i
                      ></span>
                    </div>
                    <input
                      type="file"
                      class="form-control"
                      id="photo"
                      placeholder="Employee's photograph ?"
                      aria-describedby="inputGroupPrepend3"
                      @change="setImage"
                      :class="{ 'is-invalid': !!employeeErrors.photo }"
                    />
                    <div v-if="!!employeeErrors.photo" class="invalid-feedback">
                      {{ employeeErrors.photo[0] }}
                    </div>
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
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      sms: null,
      smsEmployee: null,
      isUpdating: false,
      name: null,
      phonenumber: null,
      email: null,
      duty_type: '',
      photo: null,
      designation_id: '',
    };
  },

  watch: {
    dialog(new_val) {
      if (new_val) {
        $("#designationModal").modal("hide");
        this.clearFields();
      }
    },

    smsDialog (new_val) {
      if (new_val) {
        $("#smsModal").modal("hide");
        this.sms = null
        this.smsEmployee =null
      }
    },
  },

  computed: {
    ...mapGetters({
      employees: "getEmployees",
      employeeErrors: "getEmpErrors",
      dialog: "getCloseDialogEmp",
      smsDialog: "getSmsDialog",
      designations: "getDesignations",
    }),
  },

  mounted() {
    this.getAllEmployees();
    this.getDesignations()
  },

  methods: {
    ...mapActions({
      getAllEmployees: "getEmployeesAction",
      createEmployee: "createEmployeeAction",
      updateEmployee: "updateEmployeeAction",
      destroyEmployee: "deleteEmployeeAction",
      getDesignations: "getDesignationsAction",
      send: "sendSMSAction"
    }),

    sendSMS () {
      const data = {
        employee_id: this.smsEmployee.id,
        phonenumber: this.smsEmployee.phonenumber,
        message: this.sms
      }

      this.send(data)
    },

    setImage(e) {
      this.photo = e.target.files[0];
      console.log(this.photo);
    },

    clearFields() {
      this.id = null;
      this.name = null;
      this.phonenumber = null;
      this.email = null;
      this.designation_id = null;
      this.duty_type = null;
      this.photo = null;
    },

    showModal(updating, employee) {
      this.isUpdating = updating;
      if (this.isUpdating) {
        this.id = employee.id;
        this.name = employee.user.name;
        this.email = employee.user.email;
        this.phonenumber = employee.phonenumber;
        this.designation_id = employee.designation_id;
        this.duty_type = employee.duty_type;
      }
      $("#designationModal").modal("show");
    },

    createAndUpdateEmployee() {
      const data = new FormData();
      data.append("name", this.name);
      data.append("phonenumber", this.phonenumber);
      data.append("email", this.email);
      data.append("designation_id", this.designation_id);
      data.append("duty_type", this.duty_type);
      data.append("photo", this.photo);

      if (this.isUpdating) {
        const updateData = {
          id: this.id,
          data: data,
        };
        this.updateEmployee(updateData);
      } else {
        this.createEmployee(data);
      }
    },

    deleteEmployee(id) {
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
            this.destroyEmployee(id);
          }
        });
    },

    showSMSModal (employee) {
      this.smsEmployee = employee
      $("#smsModal").modal("show");
    }
  },
};
</script>
