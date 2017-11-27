import { mount } from 'vue-test-utils';

import Countdown from '../../resources/assets/js/components/Countdown.vue';
import expect from 'expect';
import moment from 'moment';
import sinon from 'sinon';

describe('Counter', () => {
    let wrapper,clock;

    beforeEach(() => {
        clock = sinon.useFakeTimers();
        wrapper = mount(Countdown,{
            propsData:{
                until: moment().add(10, 'seconds')
            };
        });
    });

    afterEach(()=>{
        clock.restore();
    });

    it('it sees the Example Component', () => {
        expect(wrapper.html()).toContain('Days');
    });

 
    it('it render a countdown timer', () => {
        //wrapper.setProps({ until: moment().add(10,'seconds')});
        
        //see('10 secondes');

        see('0 Days');
        see('0 Hours');
        see('0 Minutes');
        see('10 Seconds');   

        //<countdonw until ="December 5 2016>" 
    });

    it('reduces the countdown every second',(done)=>{
       // wrapper.setProps({ until: moment().add(10, 'seconds') });

        see('10 Seconds');   
        
        clock.tick(1000);

        assertOnNextTick(()=>{
            see('9 Seconds');  
        },done);
        /*wrapper.vm.$nextTick(()=>{
            try{
                see('9 Seconds');  
                done();
                
            }catch(e)
            {
                done(e);
            }
        });
        */
    });

    it('shows an expired message when the countdown has completed', (done)=>{
        //wrapper.setProps({ until: moment().add(10, 'seconds') });

        clock.tick(10000);

        assertOnNextTick(() => {
            see('Now Expired');
        }, done);


    });

    it('broadcasts when the countdown expired',(done)=>{
        //wrapper.setProps({ until: moment().add(10, 'seconds') });

        clock.tick(10000);

        assertOnNextTick(() => {
            expect(wrapper.emitted().finished).toBeTruthy();
        }, done);

    });

    it.only('show a custom expired message when the countdown has completed', (done) => {
        wrapper.setProps({ 
            //until: moment().add(10, 'seconds'), 
            expiredText :'I am done',
        });

        clock.tick(10000);

        assertOnNextTick(() => {
            see('I am done');
        }, done);

    });

    //<countdown @finished="method"

    it('clear the interval once completed', (done) => {
        /*wrapper.setProps({
            until: moment().add(10, 'seconds'),
        });
        */
       

        //console.log(wrapper.vm.now.getSeconds());
        
        clock.tick(10000);

        //expect(wrapper.vm.now.getSeconds()).toBe(10);
        
        assertOnNextTick(() => {
            clock.tick(5000);
            expect(wrapper.vm.now.getSeconds()).toBe(0);
            // expect(wrapper.vm.now.getSeconds()).toBe(0);
        }, done);
    });

    let see = (text, selector) => {
        let wrap = selector ? wrapper.find(selector) : wrapper;
        expect(wrap.html()).toContain(text);
    };

    let type = (text, selector) => {
        let node = wrapper.find(selector);

        node.element.value = text;
        node.trigger('input');
    };

    let click = selector => {
        wrapper.find(selector).trigger('click');
    };


    let assertOnNextTick = (callback,done)=>{
        wrapper.vm.$nextTick(() => {
           
            try {
                callback();
                done();
            } catch (e) {
                done(e);
            }

        });
    };

})