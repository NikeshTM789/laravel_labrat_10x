import { defineStore } from 'pinia';

export const useBearerStore = defineStore('bearerStore', {
	state: () => ({
		'token': null
		}),
	getters:{//somewhat like computed properties(vue)
		getBearer(){
			return this.token;
		}
	},
	actions:{
		setBearer(token){
			this.token = `Bearer ${token}`;
			// console.log("this.token", this.token);
		}
	}
});