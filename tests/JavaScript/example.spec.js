import {mount} from 'vue-test-utils';

import Example from '../../resources/assets/js/components/ExampleComponent.vue';
import expect from 'expect';

describe('CouponCode',()=>{
    let wrapper ;
 	beforeEach(()=>{
        wrapper  = mount(Example);

        
    });  
    it('it sees the Example Component',()=>{
        expect(wrapper.html()).toContain('Example Component');
    });
});