package com.example.team8.urlms;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;

import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.*;

import static android.R.id.message;
import static com.example.team8.urlms.R.string.staff;

public class StaffListPage extends AppCompatActivity {
    private URLMS urlms;
    private String fileName;
    Controller controller = new Controller();
    StaffController sc = new StaffController();
    ListAdapter viewStaffAdapter;

    Button backButton;
    Button refreshButton;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_staff_list_page);

        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();

        Bundle b =this.getIntent().getExtras();
        final String[] staffList = b.getStringArray("data");

        List<StaffMember> sm = sc.viewStaffList();
        final String[] staffMembers = new String[sm.size()];
        int i=0;
        for(StaffMember member : sm){
            staffMembers[i]="ID: "+ member.getId()+ " Name: " + member.getName();
            i++;
        }



        viewStaffAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, staffMembers);
        ListView buckyListView = (ListView) findViewById(R.id.buckyListView);
        buckyListView.setAdapter(viewStaffAdapter);

        buckyListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast myToast= Toast.makeText(getApplicationContext(),"You have clicked on " +staffMembers[position],Toast.LENGTH_SHORT);
                myToast.show();
                sc.save();
                Intent intent = new Intent(getApplicationContext(),StaffMemberPage.class );
                intent.putExtra("memberPosition", position);
                finish();
                startActivity(intent);

            }
        });

        refreshButton = (Button) findViewById(R.id.refreshButton);
        backButton = (Button) findViewById(R.id.backButton);
        setRefreshButton();
        setBackButton();
    }


    //button methods
    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {sc.save();
            finish();
            }
        });
    }
    public void startActivity(Class<?> cls){
        sc.save();
        Intent intent = new Intent(this,cls );
        startActivity(intent);
        finish();
    }
    public void setRefreshButton(){
        refreshButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                toastMessage("Refreshed");
                recreate();
            }
        });

    }
    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
}
