import 'choices.js/public/assets/scripts/choices.min.js';

const SELECTOR = '.js-choice';

function createAll() {

    let elementList = document.querySelectorAll(SELECTOR);

    for (let index = 0; index < elementList.length; index++) {

        let element = elementList[index];
    
        const choices = new Choices(element, {
            silent: false,
            items: [],
            choices: [],
            renderChoiceLimit: -1,
            maxItemCount: -1,
            addItems: true,
            addItemFilter: null,
            removeItems: true,
            removeItemButton: false,
            editItems: false,
            allowHTML: true,
            duplicateItemsAllowed: true,
            delimiter: ',',
            paste: true,
            searchEnabled: true,
            searchChoices: true,
            searchFloor: 1,
            searchResultLimit: 4,
            searchFields: ['label', 'value'],
            position: 'auto',
            resetScrollPosition: true,
            shouldSort: true,
            shouldSortItems: false,
            //   sorter: () => {...},
            placeholder: true,
            placeholderValue: null,
            searchPlaceholderValue: null,
            prependValue: null,
            appendValue: null,
            renderSelectedChoices: 'auto',
            loadingText: 'Carregando ...',
            noResultsText: 'Nenhum resultado encontrado',
            noChoicesText: 'Sem opções para escolher',
            itemSelectText: 'Precione para selecionar',
            uniqueItemText: 'Somente valores exclusivos podem ser adicionados',
            customAddItemText: 'Somente valores correspondentes a condições específicas podem ser adicionados',
            addItemText: (value) => {
                return `Pressione Enter para adicionar <b>"${value}"</b>`;
            },
            maxItemText: (maxItemCount) => {
                return `Somente ${maxItemCount} valores podem ser adicionados`;
            },
            valueComparer: (value1, value2) => {
                return value1 === value2;
            },
            classNames: {
                containerOuter: 'choices',
                containerInner: 'choices__inner',
                input: 'choices__input',
                inputCloned: 'choices__input--cloned',
                list: 'choices__list',
                listItems: 'choices__list--multiple',
                listSingle: 'choices__list--single',
                listDropdown: 'choices__list--dropdown',
                item: 'choices__item',
                itemSelectable: 'choices__item--selectable',
                itemDisabled: 'choices__item--disabled',
                itemChoice: 'choices__item--choice',
                placeholder: 'choices__placeholder',
                group: 'choices__group',
                groupHeading: 'choices__heading',
                button: 'choices__button',
                activeState: 'is-active',
                focusState: 'is-focused',
                openState: 'is-open',
                disabledState: 'is-disabled',
                highlightedState: 'is-highlighted',
                selectedState: 'is-selected',
                flippedState: 'is-flipped',
                loadingState: 'is-loading',
                noResults: 'has-no-results',
                noChoices: 'has-no-choices'
            },
            // Choices uses the great Fuse library for searching. You
            // can find more options here: https://fusejs.io/api/options.html
            fuseOptions: {
                includeScore: true
            },
            labelId: '',
            callbackOnInit: null,
            callbackOnCreateTemplates: null
        });    
    }    
}

export default {
    SELECTOR,
    createAll
};