// GridRow.ts
import { Node, mergeAttributes } from '@tiptap/core'

export const GridRow = Node.create({
    name: 'gridRow',
    group: 'block',
    content: 'gridColumn+',
    selectable: false,
    defining: true,

    parseHTML() {
        return [{ tag: 'div[data-type="grid-row"]' }]
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'div',
            mergeAttributes(HTMLAttributes, {
                'data-type': 'grid-row',
                class: 'grid grid-cols-12 gap-2 my-4', // Tailwind
                style: `
                      display: grid;
                      grid-template-columns: repeat(12, minmax(0, 1fr));
                      gap: 0.5rem;
                      margin-top: 1rem;
                      margin-bottom: 1rem;
                    `,
            }),
            0,
        ]
    },
})

export const GridColumn = Node.create({
    name: 'gridColumn',
    group: 'block',
    content: 'block+',
    defining: true,

    addAttributes() {
        return {
            colspan: {
                default: 12,
                parseHTML: el =>
                    parseInt(el.getAttribute('data-colspan') || '12', 10),
                renderHTML: attrs => ({
                    'data-colspan': attrs.colspan,
                }),
            },
        }
    },

    parseHTML() {
        return [{ tag: 'div[data-type="grid-column"]' }]
    },

    renderHTML({ HTMLAttributes, node }) {
        const colspan = node.attrs.colspan || 12
        const tailwindClass = `col-span-${colspan}`

        return [
            'div',
            mergeAttributes(HTMLAttributes, {
                'data-type': 'grid-column',
                class: `${tailwindClass} p-2 border border-gray-300 rounded`,
                style: `
          grid-column: span ${colspan} / span ${colspan};
          padding: 0.5rem;
          border: 1px solid #d1d5db;
          border-radius: 0.375rem;
        `,
            }),
            0,
        ]
    },
})

export const insertGridRow = (columnCount = 3, editor) => {
    const columns = Array.from({ length: columnCount }, (_, i) => ({
        type: 'gridColumn',
        attrs: {
            span: Math.floor(12 / columnCount),
        },
        content: [
            {
                type: 'paragraph',
                content: [{ type: 'text', text: `Column ${i + 1}` }],
            },
        ],
    }))

    editor
        .chain()
        .focus()
        .insertContent({
            type: 'gridRow',
            content: columns,
        })
        .run()
}
