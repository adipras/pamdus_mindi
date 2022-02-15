export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.type === 'admin';
    }

    isPelanggan(){
        return this.user.type === 'pelanggan';
    }

    // isAdminOrUser(){
    //     if(this.user.type === 'user' || this.user.type === 'admin'){
    //         return true;
    //     }
    // }
}

