package com.example.team8.urlms;

import android.database.Cursor;
import android.os.Looper;
import android.support.test.rule.ActivityTestRule;

import org.junit.After;
import org.junit.Before;
import org.junit.Rule;
import org.junit.Test;

import static android.R.attr.button;
import static org.junit.Assert.*;
/**
 * Created by ericvuong on 2017-10-17.
 */
public class MainActivityTest {

    @Rule
    public ActivityTestRule<MainActivity> mActivityTestRule = new ActivityTestRule<MainActivity>(MainActivity.class);
    private MainActivity mActivity = null;

    @Before
    public void setUp() throws Exception {
        mActivity = mActivityTestRule.getActivity();
    }

    @Test
    public void testViewStaffList(){
//        tests refresh button====================
        Looper.prepare();
        assertEquals(mActivity.toDisplay.getText().toString(), "");



        //tests viewStaffList button==============
        Looper.prepare();


    }

    @After
    public void tearDown() throws Exception {
    mActivity = null;
    }

}