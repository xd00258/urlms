package com.example.team8.urlms;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.io.Serializable;
import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;

public class StaffPage extends AppCompatActivity {

    private URLMS urlms;
    private String fileName;
    Controller controller = new Controller();
    StaffController sc = new StaffController();


    TextView toDisplay;
    Button backButton;
    Button viewStaffListButton;
    Button addMemberButton;
    EditText insertName;
    EditText insertWeeklySalary;

    CheckBox researchAssistantBox;
    CheckBox researchAssociateBox;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_staff_page);

        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();

        //buttons
        backButton = (Button) findViewById(R.id.backButton);
        viewStaffListButton = (Button) findViewById(R.id.viewStaffList);

        addMemberButton = (Button) findViewById(R.id.addMemberButton);

        //textviews
        toDisplay = (TextView) findViewById(R.id.toDisplay);

        int numberOfMember = sc.viewStaffList().size();
        String currentMembers = "Current Staff: " + numberOfMember;
        toDisplay.setText(currentMembers);

        //checkbox
        researchAssistantBox = (CheckBox) findViewById(R.id.researchAssistantBox);
        researchAssociateBox = (CheckBox) findViewById(R.id.researchAssociateBox);

        //EditText
        insertName = (EditText) findViewById(R.id.insertName);
        insertWeeklySalary = (EditText) findViewById(R.id.insertWeeklySalary);

        //initiate buttons
        setBackButton();
        setViewStaffListButton();
        setAddMemberButton();
    }

    //button methods

    private void setAddMemberButton() {
        addMemberButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(!insertName.getText().toString().equals("") && !insertWeeklySalary.getText().toString().equals("")&!insertWeeklySalary.getText().toString().equals(".")) {
                    sc.addStaffMember(insertName.getText().toString(), researchAssistantBox.isChecked(), researchAssociateBox.isChecked(),
                            Double.parseDouble(insertWeeklySalary.getText().toString()));
                    toastMessage("Member successfully added.");
                    recreate();
                }else{toastMessage("Please fill in any missing field.");
                }
            }
        });
    }

    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    public void setViewStaffListButton(){
        viewStaffListButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //package the bundle========================================================
                List<StaffMember> sm = sc.viewStaffList();
                String[] staffMembers= new String[sm.size()];
                int i=0;
                for(StaffMember member : sm){
                    staffMembers[i]="ID: "+ member.getId()+ " Name: " + member.getName();
                    i++;
                }

                Bundle b = new Bundle();
                b.putStringArray("data", staffMembers);
                //==========================================================================

                Intent intent = new Intent(getApplicationContext(),StaffListPage.class );
                intent.putExtras(b);
                startActivity(intent);

            }
        });
    }


    //initiate new activity 
    public void startActivity(Class<?> cls){
        sc.save();
        Intent intent = new Intent(this,cls );
        startActivity(intent);
    }
    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
}
