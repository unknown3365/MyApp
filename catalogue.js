document.addEventListener('DOMContentLoaded', function() {
    const filterBox = document.querySelectorAll('.items');
    
    document.querySelector('.filters_header').addEventListener('click', event => {
        if (event.target.tagName !== 'LI') return false;
        
        let filterClass = event.target.dataset['f'];
    
        filterBox.forEach(elem => {
            elem.classList.remove('hide');
            if (!elem.classList.contains(filterClass) && filterClass !== 'all') {
                elem.classList.add('hide');
            }
        });
    });
});
