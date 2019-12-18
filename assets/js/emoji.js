window.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#emoji-button');
    const picker = new EmojiButton();
  
    picker.on('emoji', emoji => {
      document.querySelector('#inputmessagehere').value += emoji;
    });
  
    button.addEventListener('click', () => {
      picker.pickerVisible ? picker.hidePicker() : picker.showPicker(button);
    });
  });
  
  const picker = new EmojiButton({
  
  // position of the emoji picker. Available positions:
  // auto-start, auto-end, top, top-start, top-end, right, right-start, right-end, bottom, bottom-start, bottom-end, left, left-start, left-end
  position: auto,
  
  // root element
  rootElement: document.body,
  
  // auto close the emoji picker after selection
  autoHide: true,
  
  // auto move focus to search field or not
  autoFocusSearch: true,
  
  // show the emoji preview
  showPreview: true,
  
  // show the emoji search input
  showSearch: true,
  
  // show recent emoji
  showRecents: true,
  
  // show skin tone variants
  showVariants: true,
  
  // maximum number of recent emojis to save
  recentsCount: 50,
  
  // z-index property
  zIndex: 999,
  
  // i18n
  i18n: {
    search: 'Search',
    categories: {
      recents: 'Recently Used',
      smileys: 'Smileys & People',
      animals: 'Animals & Nature',
      food: 'Food & Drink',
      activities: 'Activities',
      travel: 'Travel & Places',
      objects: 'Objects',
      symbols: 'Symbols',
      flags: 'Flags'
    },
    notFound: 'No emojis found'
  }
  
  });
  // shows the emoji picker
  picker.showPicker(Element);
  
  // hides the emoji picker
  picker.hidePicker();
  
  // checks if is visible
  picker.pickerVisible();
  // shows the emoji picker