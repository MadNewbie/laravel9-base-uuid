document.addEventListener('DOMContentLoaded', (event)=>{
    methods.dropdownMenuListener();
});

const methods = {
    dropdownMenuListener(){
        const elDropdownMenus = document.getElementsByClassName('dropdown');
        for (let el of elDropdownMenus) {
            el.addEventListener('click',(event) => {
                this.dropdownClick(event);
            });
        }
    },
    dropdownClick(event){
        const target = event.target;
        const parent = target.parentNode;
        const dropdownMenu = parent.getElementsByClassName('dropdown-menu')[0];
        if(dropdownMenu.classList.contains('show')){
            dropdownMenu.classList.remove('show');
        } else {
            dropdownMenu.classList.add('show');
        }
    }
}