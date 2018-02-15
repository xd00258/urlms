package com.example.team8.urlms;

import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.text.DecimalFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.ProgressUpdate;
import ca.mcgill.ecse321.urlms.model.ResearchAssistant;
import ca.mcgill.ecse321.urlms.model.ResearchAssociate;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;

import static com.example.team8.urlms.R.id.toDisplay;

public class StaffMemberPage extends AppCompatActivity {

    private URLMS urlms;
    private String fileName;
    String date = "";


    Controller c = new Controller();
    StaffController sc = new StaffController();

    TextView memberName;
    TextView memberID;
    TextView progressUpdate;

    Button backButton;
    Button viewProgressButton;
    Button addProgressButton;
    Button editButton;
    Button deleteButton;

    EditText editName;
    EditText editId;
    EditText editWeeklySalary;

    CheckBox researchAssistantBox;
    CheckBox researchAssociateBox;

    DecimalFormat format = new DecimalFormat("#.00");

    int position;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_staff_member_page);
        //retrieve bundle
        position = getIntent().getExtras().getInt("memberPosition");

        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();


        backButton = (Button) findViewById(R.id.backButton);
        editButton = (Button) findViewById(R.id.editButton);
        viewProgressButton = (Button) findViewById(R.id.viewProgressButton);
        addProgressButton = (Button) findViewById(R.id.addProgress);
        deleteButton = (Button) findViewById(R.id.deleteButton);


        memberName = (TextView) findViewById(R.id.memberName);
        memberName.setText(sc.viewStaffMemberName(position));

        memberID = (TextView) findViewById(R.id.memberID);
        memberID.setText(sc.viewStaffMemberID(position));

        editName = (EditText) findViewById(R.id.editName);
        editName.setText(sc.viewStaffMemberName(position));
        editId = (EditText) findViewById(R.id.editId);
        editId.setText(sc.viewStaffMemberID(position));
        editWeeklySalary =(EditText) findViewById(R.id.editWeeklySalary);
        editWeeklySalary.setText(String.valueOf(format.format(Double.parseDouble(sc.viewStaffMemberWeeklySalary(position)))));


        progressUpdate = (TextView) findViewById(R.id.progressText);
        progressUpdate.setVisibility(View.INVISIBLE);
        progressUpdate.setMovementMethod(new ScrollingMovementMethod());

        researchAssistantBox = (CheckBox) findViewById(R.id.researchAssistantBox);
        researchAssociateBox = (CheckBox) findViewById(R.id.researchAssociateBox);

        List<StaffMember> members = sc.viewStaffList();
        StaffMember currentMember = members.get(position);

        if (currentMember.hasResearchRoles()) {
            int rolesSize = currentMember.getResearchRoles().size();
            for (int i = 0; i < rolesSize; i++) {
                if (currentMember.getResearchRole(i) instanceof ResearchAssistant) {
                    researchAssistantBox.setChecked(true);
                }
                if (currentMember.getResearchRole(i) instanceof ResearchAssociate) {
                    researchAssociateBox.setChecked(true);
                }
            }
        }
        setEditButton();
        setBackButton();
        setViewProgressButton();
        setAddProgressButton();
        setDeleteButton();

    }
    //add progress dialog
    private void setAddProgressButton(){
        addProgressButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final AlertDialog.Builder mBuilder = new AlertDialog.Builder(StaffMemberPage.this);
                View mView = getLayoutInflater().inflate(R.layout.dialog_add_progress, null);
                final EditText mProgress = (EditText) mView.findViewById(R.id.editTextProgress);
                final DatePicker mDatePicker = (DatePicker) mView.findViewById(R.id.datePicker);
                Button mConfirm = (Button) mView.findViewById(R.id.buttonConfirm);
                mBuilder.setView(mView);
                final AlertDialog dialog = mBuilder.create();
                dialog.show();
               date = new SimpleDateFormat("MM-dd-yyyy").format(new Date());
                Calendar cal = Calendar.getInstance();
                int year = cal.get(Calendar.YEAR);
                int month = cal.get(Calendar.MONTH);
                int day = cal.get(Calendar.DAY_OF_MONTH)+1;
                mDatePicker.init(year, month, day, new DatePicker.OnDateChangedListener() {
                    @Override
                    public void onDateChanged(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                        date = (monthOfYear+1)+ "-"+dayOfMonth+ "-"+year;
                    }
                });
                mConfirm.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if(!mProgress.getText().toString().isEmpty()){
                            sc.addProgress(date, mProgress.getText().toString(),position);
                            toastMessage("Progress Updated.");
                            dialog.dismiss();
                        }
                        else{
                            toastMessage("Please fill any empty fields.");
                        }
                    }
                });
            }
        });
        sc.save();
      }
    //display progress scrollable text
    private void setViewProgressButton() {
        viewProgressButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                progressUpdate.setVisibility(View.VISIBLE);
                List<ProgressUpdate> progress = sc.viewProgressUpdate(position);
                String progressToDisplay = "";
                for(int i=0; i<progress.size();i++){
                    progressToDisplay+= progress.get(i).getDate()+"\n";
                    progressToDisplay+= progress.get(i).getDescription()+"\n\n";
                    progressUpdate.setText(progressToDisplay);
                }
            }
        });
        sc.save();
    }
    //button methods
    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                sc.save();
                finish();
            }
        });
    }
    public void setEditButton(){
        editButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(editName.getText().toString().isEmpty()&&!editWeeklySalary.getText().toString().equals(".")){
                    toastMessage("You didn't enter a string or you didn't fit the weekly salary. ");
                }
                else sc.editStaffmemberRecord(position,Integer.parseInt(editId.getText().toString()),
                        editName.getText().toString(),
                        researchAssistantBox.isChecked(),
                        researchAssociateBox.isChecked(),
                Double.parseDouble(editWeeklySalary.getText().toString()));
                toastMessage("Member successfully updated, refresh page to see.");
                sc.save();
            }
        });
    }

    public void setDeleteButton(){
        deleteButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
            deleteAllAuthorization();
            }
        });
    }

    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }

    //admin consent
    public void deleteAllAuthorization(){
        AlertDialog.Builder alert = new AlertDialog.Builder(this);
        alert.setMessage("Admin Access Required.")
                .setCancelable(false)
                .setPositiveButton("Allow", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        sc.removeStaffMember(position);
                        toastMessage("Member sucessfully deleted.");
                        sc.save();
                        finish();
                    }
                })
                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.cancel();
                    }
                });
        AlertDialog display = alert.create();
        alert.setTitle("Admin");
        alert.show();
    }


}

