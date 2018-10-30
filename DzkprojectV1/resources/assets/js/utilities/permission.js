
import axios from 'axios'
import * as Config from '../../config'

const actions = {
  logout ({commit, dispatch}, perm) {
    commit('LOGOUT_OK')
    let permissions = (localStorage.getItem('permissions'))
    permissions = permissions.split(",")

	let permission (permissions.indexOf(perm) !== -1)

    localStorage.removeItem('access_token')
  },
}

const mutations = {

  LOGOUT_OK (state) {

  },

}

export default {
  actions,
  mutations
}
