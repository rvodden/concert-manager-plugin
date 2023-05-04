(function (blocks, element, data, blockEditor) {
    var el = element.createElement,
        useSelect = data.useSelect,
        useBlockProps = blockEditor.useBlockProps,
        registerBlockType = blocks.registerBlockType;

    registerBlockType('concert-manager/next-concert-block', {
        edit: function () {
            var content;
            var blockProps = useBlockProps();
            var concerts = useSelect(function (select) {
                return select('core').getEntityRecords('postType', 'concert');
            }, []);
            if (!concerts) {
                content = 'Loading ...';
            } else if (concerts.length === 0) {
                content = "There are no concerts.";
            } else {
                var concert = concerts[0];
                content = [
                    el('p', concert.),
                    el('a', { href: concert.link }, concert.title.rendered)
                ]
            }
            return el('div', blockProps, content);
        },
        save: function () {
            return null;
        }
    });

})(window.wp.blocks, window.wp.element, window.wp.data, window.wp.blockEditor);
