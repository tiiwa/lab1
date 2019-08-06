<template>
	<div :tabindex="tabIndex" 
		:class="['filter-box-select', ...classes]" 
		@focus="onSelectBoxFocus" 
		@click="onSelectBoxFocus" 
		@blur="onSelectBoxBlur">
		<div :class="[isActive ? 'active': '', 'filter-box-select-styled']">{{ selectDisplayValue }}</div>
		<ul :class="[showOptions ? 'active': '', 'filter-box-select-options']">
			<li v-for="option in selectOptions"
				:key="option"
				:rel="option"
				@click="onOptionClicked($event, option)">{{ option }}</li>
		</ul>
	</div>
</template>

<script>
export default {
	name: "FilterBoxSelect",

	props: {
		onSelect: {
			type: Function,
			default: (option) => {},
		},
		value: {
			type: String,
			default: null,
		},
		placeholder: {
			type: String,
			default: "Select",
		},
		options: {
			type: Array,
			default: () => [],
		},
		tabIndex: {
			type: Number,
			default: 0,
		},
		classes: {
			type: Array,
			default: () => [],
		}
	},

	data() {
		return {
			isActive: false,
			showOptions: false,
		};
	},

	computed: {
		/**
		 * Computed list of options. This allows us to add a default
		 * empty option to the mix.
		 */
		selectOptions: function() {
			return [this.placeholder, ...this.options];
		},

		/**
		 * Computed Display Value. If there is no current value, then just use the placeholder.
		 */
		selectDisplayValue: function() {
			return (this.value && this.value.trim() !== "") ? this.value : this.placeholder;
		},
	},

	methods: {
		onOptionClicked: function(event, option) {
			let optionSelected = option;

			if (option === this.placeholder) {
				optionSelected = null;
			}

			this.showOptions = false;
			this.isActive = false;

			this.onSelect(optionSelected);

			event.stopPropagation();
		},

		onSelectBoxFocus: function(event) {
			this.isActive = true;
			this.showOptions = true;
		},

		onSelectBoxBlur: function(event) {
			this.isActive = false;
			this.showOptions = false;
		},
	}
};
</script>



<style lang="scss" scoped>
// Scoped variables only for this component
$select-color: #d3d3d3;
$select-background: #f6f6f6;
$select-height: 36px;

.select-hidden {
	display: none;
	padding-right: 10px;
	visibility: hidden;
}

.filter-box-select {
	position: relative;
	display: inline-block;
	height: $select-height;
	font-size: 14px;
	color: $select-color;
	cursor: pointer;
}

.filter-box-select-styled {
	padding: 8px 30px 8px 15px;
	background-color: $select-background;

	&::after {
		position: absolute;
		top: 15px;
		right: 10px;
		width: 0;
		height: 0;
		content: "";
		border: 5px solid transparent;
		border-color: $select-color transparent transparent transparent;
	}

	&:hover {
		background-color: darken($select-background, 2);
	}

	&.active,
	&:focus {
		background-color: darken($select-background, 5);

		&::after {
			top: 9px;
			border-color: transparent transparent $select-color transparent;
		}
	}
}

.filter-box-select-options {
	position: absolute;
	top: 36px;
	z-index: 1;
	display: none;
	width: 300px;
	max-height: 300px;
	padding: 0;
	margin: 0 auto;
	overflow: scroll;
	list-style: none;
	background-color: white;
	border: 1px solid $select-background;

	li {
		height: 42px;
		padding: 12px 0;
		margin: 0;
		color: darken($select-color, 10);
		text-indent: 15px;

		&:hover {
			color: $blue;
			background: $select-background;
		}

		&:not(:first-child) {
			border-top: 1px solid $select-background;
		}
	}

	&.active {
		display: inline-block;
	}
}
</style>
